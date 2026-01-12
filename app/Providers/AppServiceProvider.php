<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Seance;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.default');

        // Gate 1 удалять сеансы может только админ
        Gate::define('delete-seance', function (User $user) {
            return (int)$user->is_admin === 1;
        });

        // Gate 2 редактировать можно только если сеанс в будущем или админ
        Gate::define('edit-seance', function (User $user, Seance $seance) {
            if ((int)$user->is_admin === 1) return true;
            return $seance->start_at > now();
        });
    }
}
