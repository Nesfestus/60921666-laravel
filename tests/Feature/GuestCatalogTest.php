<?php

namespace Tests\Feature;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GuestCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_search_and_paginate_movies(): void
    {
        Movie::create(['name' => 'Orbit One', 'duration' => 120]);
        $second = Movie::create(['name' => 'Orbit Two', 'duration' => 130]);
        Movie::create(['name' => 'Another Film', 'duration' => 90]);

        $this->getJson('/api/movie?search=Orbit&page=1&perpage=1')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.id', $second->id);

        $this->getJson('/api/movies_total?search=Orbit')
            ->assertOk()
            ->assertContent('2');

        $this->getJson('/api/movie/'.$second->id)
            ->assertOk()
            ->assertJsonPath('name', 'Orbit Two');
    }

    public function test_guest_can_view_halls_and_their_count(): void
    {
        $hall = Hall::forceCreate(['name' => 'Main Hall']);
        Hall::forceCreate(['name' => 'Small Hall']);

        $this->getJson('/api/hall?page=0&perpage=1')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonPath('0.id', $hall->id);

        $this->getJson('/api/halls_total')->assertOk()->assertContent('2');
        $this->getJson('/api/hall/'.$hall->id)
            ->assertOk()
            ->assertJsonPath('name', 'Main Hall');
    }

    public function test_guest_cannot_create_update_or_delete_movies(): void
    {
        $movie = Movie::create(['name' => 'Original', 'duration' => 100]);

        $this->postJson('/api/movie', ['name' => 'New', 'duration' => 90])
            ->assertUnauthorized();
        $this->postJson('/api/movie/'.$movie->id, ['name' => 'Changed', 'duration' => 90])
            ->assertUnauthorized();
        $this->deleteJson('/api/movie/'.$movie->id)->assertUnauthorized();

        $this->assertDatabaseCount('movies', 1);
        $this->assertDatabaseHas('movies', ['id' => $movie->id, 'name' => 'Original']);
    }

    public function test_regular_user_can_read_but_cannot_change_movies(): void
    {
        $movie = Movie::create(['name' => 'Original', 'duration' => 100]);
        $this->actingAs($this->user(false), 'sanctum');

        $this->getJson('/api/movie')->assertOk();
        $this->getJson('/api/hall')->assertOk();
        $this->postJson('/api/movie', ['name' => 'New', 'duration' => 90])
            ->assertForbidden();
        $this->postJson('/api/movie/'.$movie->id, ['name' => 'Changed', 'duration' => 90])
            ->assertForbidden();
        $this->deleteJson('/api/movie/'.$movie->id)->assertForbidden();

        $this->assertDatabaseCount('movies', 1);
        $this->assertDatabaseHas('movies', ['id' => $movie->id, 'name' => 'Original']);
    }

    public function test_administrator_can_update_and_delete_a_movie_without_seances(): void
    {
        $movie = Movie::create(['name' => 'Original', 'duration' => 100]);
        $this->actingAs($this->user(true), 'sanctum');

        $this->postJson('/api/movie/'.$movie->id, ['name' => 'Updated', 'duration' => 110])
            ->assertOk()
            ->assertJsonPath('movie.name', 'Updated');
        $this->assertDatabaseHas('movies', ['id' => $movie->id, 'duration' => 110]);

        $this->deleteJson('/api/movie/'.$movie->id)->assertOk();
        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }

    private function user(bool $admin): User
    {
        return User::forceCreate([
            'name' => $admin ? 'Admin' : 'Member',
            'email' => $admin ? 'admin@test.example' : 'member@test.example',
            'password' => Hash::make('Test-only-password-123!'),
            'is_admin' => $admin,
        ]);
    }
}
