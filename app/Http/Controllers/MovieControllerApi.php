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

        return response(
            Movie::query()
                ->orderBy('id')
                ->offset($page * $perpage)
                ->limit($perpage)
                ->get()
        );
    }

    public function total(): Response
    {
        return response(Movie::count());
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
}
