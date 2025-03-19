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
| Routes authentifiées
|--------------------------------------------------------------------------
*/

// Redirection après connexion
Route::get('/redirect-dashboard', function () {
    $user = Auth::user();

    // Si l'utilisateur n'est pas connecté, rediriger vers la page de bienvenue
    if (!$user) {
        return redirect()->route('bienvenue');
    }

    // Redirection en fonction du rôle de l'utilisateur
    switch ($user->role->name) {
        case 'Administrateur':
            return redirect()->route('admin.dashboard');
        case 'Secretaire_Municipal':
            return redirect()->route('secretaire.dashboard');
        case 'Agent':
            return redirect()->route('agent.dashboard');
        default:
             // Si le rôle n'est pas reconnu, rediriger vers une page d'erreur ou lancer une exception
             abort(403, 'Rôle non reconnu.');
           // return redirect()->route('dashboard'); // Redirection par défaut
    }
})->middleware(['auth', 'verified'])->name('redirect.dashboard');



// Routes pour l'administration des utilisateurs
Route::middleware(['auth', 'role:Administrateur'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
});


/*
|--------------------------------------------------------------------------
| Routes pour les tableaux de bord (par rôle)
|--------------------------------------------------------------------------
*/
// Route pour le tableau de bord (redirection en fonction du rôle)
/*Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'redirectBasedOnRole'])->name('dashboard');
});
*/

// Routes pour l'administration des utilisateurs
Route::middleware(['auth', 'role:Administrateur'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
});


// Routes spécifiques pour chaque rôle
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/secretaire/dashboard', [DashboardController::class, 'secretaire'])->name('secretaire.dashboard');
    Route::get('/agent/dashboard', [DashboardController::class, 'agent'])->name('agent.dashboard');
});


// Tableau de bord par défaut (pour les rôles non gérés)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

Route::middleware('auth')->group(function () {
    Route::resource('courriers', CourrierController::class);
    Route::post('/courriers/{courrier}/affecter', [AffectationController::class, 'affecter'])->name('courriers.affecter');
});

/*
|--------------------------------------------------------------------------
| Routes d'authentification (générées par Laravel Breeze/Jetstream)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';