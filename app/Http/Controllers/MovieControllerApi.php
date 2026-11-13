<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MovieControllerApi extends Controller
{
    public function index(Request $request): Response
    {
        $page = max(0, (int) $request->query('page', 0));
        $perpage = max(1, (int) $request->query('perpage', 5));
        $search = trim((string) $request->query('search', ''));

        return response(
            Movie::query()
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orderBy('id')
                ->offset($page * $perpage)
                ->limit($perpage)
                ->get()
        );
    }

    public function total(Request $request): Response
    {
        $search = trim((string) $request->query('search', ''));

        return response(
            Movie::query()
                ->where('name', 'LIKE', '%' . $search . '%')
                ->count()
        );
    }

    public function show(string $id): Response
    {
        return response(Movie::find($id));
    }

    public function store(Request $request): JsonResponse
    {
        Gate::authorize('create-movie');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'duration' => ['required', 'integer', 'min:1', 'max:1440'],
            'picture' => [
                'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',
            ],
        ], [
            'name.required' => 'Укажите название фильма.',
            'name.max' => 'Название не должно превышать 200 символов.',
            'duration.required' => 'Укажите продолжительность фильма.',
            'duration.integer' => 'Продолжительность должна быть целым числом.',
            'duration.min' => 'Продолжительность должна быть больше нуля.',
            'duration.max' => 'Продолжительность не должна превышать 1440 минут.',
            'picture.required' => 'Выберите постер фильма.',
            'picture.image' => 'Файл должен быть изображением.',
            'picture.mimes' => 'Допустимые форматы: JPG, PNG, WEBP.',
            'picture.max' => 'Размер постера не должен превышать 2 МБ.',
        ]);

        // Сначала загружаем постер в хранилище
        try {
            $disk = Storage::disk('s3');
            $path = $disk->putFile('movies', $request->file('picture'));
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Не удалось загрузить постер в хранилище.',
            ], 503);
        }

        // После загрузки сохраняем фильм и ссылку на постер
        try {
            $movie = Movie::create([
                'name' => $data['name'],
                'duration' => $data['duration'],
                'picture_url' => $disk->url($path),
            ]);
        } catch (\Throwable $e) {
            report($e);

            // При ошибке сохранения удаляем загруженный постер
            try {
                $disk->delete($path);
            } catch (\Throwable $cleanupError) {
                report($cleanupError);
            }

            return response()->json([
                'message' => 'Не удалось сохранить фильм.',
            ], 500);
        }

        return response()->json([
            'message' => 'Фильм успешно добавлен.',
            'movie' => $movie,
        ], 201);
    }

    public function destroy(string $id): JsonResponse
    {
        if (Gate::denies('delete-movie')) {
            return response()->json([
                'message' => 'У вас нет прав на удаление фильмов.',
            ], 403);
        }

        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'message' => 'Фильм не найден.',
            ], 404);
        }

        if ($movie->seances()->exists()) {
            return response()->json([
                'message' => 'Нельзя удалить фильм, у которого есть сеансы.',
            ], 409);
        }

        $movie->delete();

        return response()->json([
            'message' => 'Фильм успешно удалён.',
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        if (Gate::denies('update-movie')) {
            return response()->json([
                'message' => 'У вас нет прав на редактирование фильмов.',
            ], 403);
        }

        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'message' => 'Фильм не найден.',
            ], 404);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'duration' => ['required', 'integer', 'min:1', 'max:1440'],
            'picture' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',
            ],
        ], [
            'name.required' => 'Укажите название фильма.',
            'name.max' => 'Название не должно превышать 200 символов.',
            'duration.required' => 'Укажите продолжительность фильма.',
            'duration.integer' => 'Продолжительность должна быть целым числом.',
            'duration.min' => 'Продолжительность должна быть больше нуля.',
            'duration.max' => 'Продолжительность не должна превышать 1440 минут.',
            'picture.image' => 'Файл должен быть изображением.',
            'picture.mimes' => 'Допустимые форматы: JPG, PNG, WEBP.',
            'picture.max' => 'Размер постера не должен превышать 2 МБ.',
        ]);

        $oldPictureUrl = $movie->picture_url;
        $newPath = null;
        $disk = null;

        try {
            // При отсутствии нового файла сохраняем прежний постер
            if ($request->hasFile('picture')) {
                $disk = Storage::disk('s3');
                $newPath = $disk->putFile('movies', $request->file('picture'));

                if (!$newPath) {
                    return response()->json([
                        'message' => 'Не удалось загрузить новый постер.',
                    ], 503);
                }

                $movie->picture_url = $disk->url($newPath);
            }

            $movie->name = $data['name'];
            $movie->duration = $data['duration'];
            $movie->save();
        } catch (\Throwable $e) {
            report($e);

            // Если обновление не удалось, убираем новый загруженный файл
            if ($newPath && $disk) {
                try {
                    $disk->delete($newPath);
                } catch (\Throwable $cleanupError) {
                    report($cleanupError);
                }
            }

            return response()->json([
                'message' => 'Не удалось обновить фильм.',
            ], 500);
        }

        // Старый постер удаляем только после успешного сохранения фильма
        if ($newPath && $oldPictureUrl) {
            try {
                $baseUrl = rtrim($disk->url(''), '/') . '/';

                if (str_starts_with($oldPictureUrl, $baseUrl)) {
                    $oldPath = substr($oldPictureUrl, strlen($baseUrl));
                    $disk->delete($oldPath);
                }
            } catch (\Throwable $cleanupError) {
                report($cleanupError);
            }
        }

        return response()->json([
            'message' => 'Фильм успешно обновлён.',
            'movie' => $movie,
        ]);
    }
}
