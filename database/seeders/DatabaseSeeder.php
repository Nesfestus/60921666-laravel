<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\Seance;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'is_admin' => 0,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => 1,
        ]);

        Hall::create([
            'name' => 'Зал 1',
        ]);

        Hall::create([
            'name' => 'Зал 2',
        ]);

        Hall::create([
            'name' => 'Зал 3',
        ]);

        Movie::create([
            'name' => 'Интерстеллар',
            'duration' => 169,
        ]);

        Movie::create([
            'name' => 'Начало',
            'duration' => 148,
        ]);

        Movie::create([
            'name' => 'Дюна',
            'duration' => 155,
        ]);

        Movie::create([
            'name' => 'Матрица',
            'duration' => 136,
        ]);

        Movie::create([
            'name' => 'Чужой',
            'duration' => 117,
        ]);

        Seance::create([
            'hall_id' => 1,
            'movie_id' => 1,
            'start_at' => now()->subDays(3)->setTime(12, 0),
        ]);

        Seance::create([
            'hall_id' => 2,
            'movie_id' => 2,
            'start_at' => now()->subDays(2)->setTime(15, 0),
        ]);

        Seance::create([
            'hall_id' => 3,
            'movie_id' => 3,
            'start_at' => now()->subDay()->setTime(18, 0),
        ]);

        Seance::create([
            'hall_id' => 1,
            'movie_id' => 4,
            'start_at' => now()->subDay()->setTime(20, 0),
        ]);

        Seance::create([
            'hall_id' => 2,
            'movie_id' => 5,
            'start_at' => now()->subDay()->setTime(21, 0),
        ]);

        Seance::create([
            'hall_id' => 1,
            'movie_id' => 1,
            'start_at' => now()->addDay()->setTime(12, 0),
        ]);

        Seance::create([
            'hall_id' => 2,
            'movie_id' => 2,
            'start_at' => now()->addDay()->setTime(15, 0),
        ]);

        Seance::create([
            'hall_id' => 3,
            'movie_id' => 3,
            'start_at' => now()->addDay()->setTime(18, 0),
        ]);

        Seance::create([
            'hall_id' => 1,
            'movie_id' => 4,
            'start_at' => now()->addDays(2)->setTime(13, 0),
        ]);

        Seance::create([
            'hall_id' => 2,
            'movie_id' => 5,
            'start_at' => now()->addDays(2)->setTime(16, 0),
        ]);

        Seance::create([
            'hall_id' => 3,
            'movie_id' => 1,
            'start_at' => now()->addDays(2)->setTime(19, 0),
        ]);

        Seance::create([
            'hall_id' => 1,
            'movie_id' => 2,
            'start_at' => now()->addDays(3)->setTime(14, 0),
        ]);

        Seance::create([
            'hall_id' => 2,
            'movie_id' => 3,
            'start_at' => now()->addDays(3)->setTime(17, 0),
        ]);

        Seance::create([
            'hall_id' => 3,
            'movie_id' => 4,
            'start_at' => now()->addDays(3)->setTime(20, 0),
        ]);

        Seance::create([
            'hall_id' => 1,
            'movie_id' => 5,
            'start_at' => now()->addDays(4)->setTime(21, 0),
        ]);

    }
}
