<?php

use App\Http\Controllers\CourrierController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return view('loader'); // Affiche l'écran de chargement en premier
})->name('home');

// Page de bienvenue
Route::get('/welcome', function () {
    return view('welcome');
})->name('bienvenue');

/*
|--------------------------------------------------------------------------
| Redirection après connexion
|--------------------------------------------------------------------------
*/

Route::get('/redirect-dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('bienvenue');
    }

    switch ($user->role->name) {
        case 'Administrateur':
            return redirect()->route('admin.dashboard');
        case 'Secretaire_Municipal':
            return redirect()->route('secretaire.dashboard');
        case 'Agent':
            return redirect()->route('agent.dashboard');
        default:
            abort(403, 'Rôle non reconnu.');
    }
})->middleware(['auth', 'verified'])->name('redirect.dashboard');

/*
|--------------------------------------------------------------------------
| Routes pour l'administration des utilisateurs
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard'); // Tableau de bord admin
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
});

/*
|--------------------------------------------------------------------------
| Routes pour les tableaux de bord (par rôle)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/secretaire/dashboard', [DashboardController::class, 'secretaire'])->name('secretaire.dashboard');
    Route::get('/agent/dashboard', [DashboardController::class, 'agent'])->name('agent.dashboard');
});

/*
|--------------------------------------------------------------------------
| Routes pour le profil utilisateur
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes pour la gestion des courriers
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Routes pour l'affectation des courriers
    Route::get('/affectation', [AffectationController::class, 'index'])->name('affectation.index');
    Route::post('/affectation/affecter', [AffectationController::class, 'affecter'])->name('affectation.affecter');
    Route::get('/affectation/create/{courrier}', [AffectationController::class, 'create'])->name('affectation.create');
    Route::post('/affectation/store', [AffectationController::class, 'store'])->name('affectation.store');

    // Routes pour la gestion des courriers
    Route::get('/courriers', [CourrierController::class, 'index'])->name('courriers.index');
    Route::get('/courriers/create', [CourrierController::class, 'create'])->name('courriers.create');
    Route::post('/courriers/envoyer', [CourrierController::class, 'envoyer'])->name('courriers.envoyer');
    Route::post('/courriers', [CourrierController::class, 'store'])->name('courriers.store');
});

// Téléchargement des pièces jointes
Route::get('/pieces-jointes/{pieceJointe}/download', [CourrierController::class, 'download'])
    ->name('pieces-jointes.download')
    ->middleware('can:download,pieceJointe');

/*
|--------------------------------------------------------------------------
| Routes d'authentification (générées par Laravel Breeze/Jetstream)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';