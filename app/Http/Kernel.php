<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends HttpKernel
{
    /**
     * Liste des middleware globaux de l'application.
     *
     * @var array
     */
    protected $middleware = [
     //   \App\Http\Middleware\TrustProxies::class, // Pour gérer les proxies
    //   \Fruitcake\Cors\HandleCors::class, // Pour gérer les en-têtes CORS
     //   \App\Http\Middleware\PreventRequestsDuringMaintenance::class, // Pour gérer le mode maintenance
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // Pour valider la taille des requêtes POST
    //    \App\Http\Middleware\TrimStrings::class, // Pour nettoyer les chaînes de caractères
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // Pour convertir les chaînes vides en null
    ];

    /**
     * Liste des groupes de middleware par défaut de l'application.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
        //   \App\Http\Middleware\EncryptCookies::class, // Pour chiffrer les cookies
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, // Pour ajouter les cookies à la réponse
            \Illuminate\Session\Middleware\StartSession::class, // Pour démarrer la session
            \Illuminate\View\Middleware\ShareErrorsFromSession::class, // Pour partager les erreurs de session avec les vues
        //  \App\Http\Middleware\VerifyCsrfToken::class, // Pour vérifier les tokens CSRF
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Pour lier les modèles aux routes
        ],

        'api' => [
            'throttle:api', // Pour limiter les requêtes API
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Pour lier les modèles aux routes
        ],
    ];

    /**
     * Liste des middleware des routes spécifiques.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'role' => \App\Http\Middleware\RoleMiddleware::class, // Votre middleware personnalisé pour les rôles
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class, // Pour vérifier l'authentification
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, // Pour l'authentification basique
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class, // Pour définir les en-têtes de cache
        'can' => \Illuminate\Auth\Middleware\Authorize::class, // Pour vérifier les autorisations
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class ?? null, // Pour rediriger les utilisateurs authentifiés
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class, // Pour confirmer le mot de passe
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class, // Pour valider les signatures des URLs
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // Pour limiter les requêtes
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Pour vérifier l'email
    ];

    /**
     * Configure the rate limit for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Schedule the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('courriers:import-emails')->everyFiveMinutes();
    }
}