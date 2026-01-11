<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\Seance;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    // список всех сеансов
    public function index()
    {
        return view('seances', [
            'seances' => Seance::with(['hall', 'movie'])
                ->orderBy('start_at')
                ->get()
        ]);
    }

    // показать 1 сеанс (как у тебя уже есть)
    public function show(string $id)
    {
        return view('seance', [
            'seance' => Seance::with(['movie', 'hall', 'seats'])
                ->where('id', $id)
                ->first()
        ]);
    }

    // форма создания
    public function create()
    {
        return view('seance_create', [
            'halls' => Hall::all(),
            'movies' => Movie::all()
        ]);
    }

    // сохранение нового сеанса
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'movie_id' => ['required', 'integer', 'exists:movies,id'],
            'start_at' => ['required', 'date'],
            'confirm'  => ['accepted'],
        ]);


        // бизнес-ограничение из твоих миграций:
        // (hall_id, start_at) должно быть уникально
        $exists = Seance::where('hall_id', $validated['hall_id'])
            ->where('start_at', $validated['start_at'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['start_at' => 'В этом зале уже есть сеанс на указанное время.'])
                ->withInput();
        }

        Seance::create($validated);

        return redirect('/seances');
    }

    // форма редактирования
    public function edit(string $id)
    {
        return view('seance_edit', [
            'seance' => Seance::findOrFail($id),
            'halls' => Hall::all(),
            'movies' => Movie::all()
        ]);
    }

    // обновление сеанса
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'hall_id' => ['required', 'integer', 'exists:halls,id'],
            'movie_id' => ['required', 'integer', 'exists:movies,id'],
            'start_at' => ['required', 'date'],
        ]);

        $seance = Seance::findOrFail($id);

        // проверка уникальности (hall_id, start_at) с исключением текущей записи
        $exists = Seance::where('hall_id', $validated['hall_id'])
            ->where('start_at', $validated['start_at'])
            ->where('id', '!=', $seance->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['start_at' => 'В этом зале уже есть сеанс на указанное время.'])
                ->withInput();
        }

        $seance->hall_id = $validated['hall_id'];
        $seance->movie_id = $validated['movie_id'];
        $seance->start_at = $validated['start_at'];
        $seance->save();

        return redirect('/seances');
    }

    // удаление
    public function destroy(string $id)
    {
        Seance::destroy($id);
        return redirect('/seances');
    }
}
