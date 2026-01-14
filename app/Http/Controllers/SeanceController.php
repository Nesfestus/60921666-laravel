<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SeanceController extends Controller
{
    // список всех сеансов
    public function index(Request $request)
    {
        $perpage = (int) $request->get('perpage', 5);

        // чтобы не ставили 999999
        if ($perpage < 1) $perpage = 5;
        if ($perpage > 50) $perpage = 50;

        return view('seances', [
            'perpage' => $perpage,
            'seances' => Seance::with(['hall', 'movie'])
                ->orderBy('start_at')
                ->paginate($perpage)
                ->withQueryString()
        ]);
    }


    // показать 1 сеанс
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


        // бизнес-ограничение из миграций:
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
        $seance = Seance::findOrFail($id);

        if (!Gate::allows('edit-seance', $seance)) {
            return redirect('/error')->with('message', 'Редактирование возможно только для будущих сеансов (или для администратора).');
        }

        return view('seance_edit', [
            'seance' => $seance,
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

        // проверка уникальности hall_id, start_at с исключением текущей записи
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
        if (!Gate::allows('delete-seance')) {
            return redirect('/error')->with('message', 'У вас нет прав на удаление сеансов.');
        }

        Seance::destroy($id);
        return redirect('/seances')->with('message', 'Сеанс успешно удалён.');

    }


}
