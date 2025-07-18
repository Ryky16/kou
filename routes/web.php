<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\CourrierController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PieceJointeController;
use App\Http\Controllers\StatistiqueController;


/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Page de chargement
Route::get('/', fn() => view('loader'))->name('home');

// Page de bienvenue
Route::get('/welcome', fn() => view('welcome'))->name('bienvenue');

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

    return match ($user->role->name) {
        'Administrateur' => redirect()->route('admin.dashboard'),
        'Secretaire_Municipal' => redirect()->route('secretaire.dashboard'),
        'Agent' => redirect()->route('agent.dashboard'),
        default => abort(403, 'Rôle non reconnu.'),
    };
})->middleware(['auth', 'verified'])->name('redirect.dashboard');

/*
|--------------------------------------------------------------------------
| Routes Authentifiées (auth.php inclus séparément)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Admin : Gestion utilisateurs + Dashboard
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

/*
|--------------------------------------------------------------------------
| Dashboards par rôle
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/secretaire/dashboard', [DashboardController::class, 'secretaire'])->name('secretaire.dashboard');
    Route::get('/agent/dashboard', [DashboardController::class, 'agent'])->name('agent.dashboard');
});

/*
|--------------------------------------------------------------------------
| Profil utilisateur
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

/*
|--------------------------------------------------------------------------
| Courriers & Affectations
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Courriers
    Route::get('/courriers', [CourrierController::class, 'index'])->name('courriers.index');
    Route::get('/courriers/create', [CourrierController::class, 'create'])->name('courriers.create');
    Route::post('/courriers', [CourrierController::class, 'store'])->name('courriers.store');
    
    Route::patch('/courriers/{courrier}', [CourrierController::class, 'update'])->name('courriers.update');
    Route::delete('/courriers/{courrier}', [CourrierController::class, 'destroy'])->name('courriers.destroy');

    Route::post('/courriers/envoyer', [CourrierController::class, 'envoyer'])->name('courriers.envoyer');
    Route::post('/courriers/{courrier}/affecter', [CourrierController::class, 'affecter'])->name('courriers.affecter');
    Route::post('/courriers/{courrier}/archiver', [\App\Http\Controllers\CourrierController::class, 'archiver'])
        ->name('courriers.archiver');
    Route::get('/courriers/archives', [CourrierController::class, 'archives'])->name('courriers.archives');
    Route::get('/courriers/{courrier}/edit', [CourrierController::class, 'edit'])->name('courriers.edit');
    Route::get('/courriers/{courrier}', [CourrierController::class, 'show'])->name('courriers.show');

    // Affectations
    Route::get('/affectation', [AffectationController::class, 'index'])->name('affectation.index');
    Route::get('/affectation/{courrier}/create', [AffectationController::class, 'create'])->name('affectation.create');
    Route::post('/affectation/affecter', [AffectationController::class, 'affecter'])->name('affectation.affecter');
    Route::post('/affectation/store', [AffectationController::class, 'store'])->name('affectation.store');
});

/*
|--------------------------------------------------------------------------
| Courrier pour secrétaire & archives agents
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/secretaire/courriers/{id}', [DashboardController::class, 'showCourrier'])->name('secretaire.courriers.show');
    Route::get('/agent/archives', [DashboardController::class, 'archives'])->name('agent.archives');
});

/*
|--------------------------------------------------------------------------
| Pièces jointes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/pieces-jointes/{pieceJointe}/download', [CourrierController::class, 'download'])
        ->name('pieces-jointes.download')
        ->middleware('can:download,pieceJointe');
    Route::patch('/pieces-jointes/{pieceJointe}', [PieceJointeController::class, 'update'])->name('pieces_jointes.update');
    Route::delete('/pieces-jointes/{pieceJointe}', [PieceJointeController::class, 'destroy'])->name('pieces_jointes.destroy');
});

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Notifications générales
    Route::patch('/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back();
    })->name('notifications.read');

    Route::delete('/notifications/{id}', function ($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return back();
    })->name('notifications.delete');

    // Notifications secrétaire
    Route::patch('/secretaire/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back();
    })->name('secretaire.notifications.read');

    Route::delete('/secretaire/notifications/{id}', function ($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return back();
    })->name('secretaire.notifications.delete');
});

/*
|--------------------------------------------------------------------------
| Statistiques 
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
});