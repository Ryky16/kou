<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Models\Role;

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
        // Définir la longueur par défaut des chaînes pour éviter les erreurs MySQL
        Schema::defaultStringLength(191);

        // Permettre l'utilisation de Bootstrap pour la pagination
        Paginator::useBootstrap();

        // Lier le modèle Role à l'application
        $this->app->bind('role', function () {
            return new Role();
        });
    }
}
