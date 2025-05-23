<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Models\User;

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
        Paginator::useBootstrap();

        // Superadmin bypass semua izin
        Gate::before(function (User $user, $ability) {
            return $user->hasRole('Superadmin') ? true : null;
        });

        // Set Local Timezone Indonesia
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
