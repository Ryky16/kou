<?php

use App\Http\Controllers\CourrierController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PieceJointeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
    Route::get('/affectation/{courrier}/create', [AffectationController::class, 'create'])->name('affectation.create');
    Route::post('/affectation/affecter', [AffectationController::class, 'affecter'])->name('affectation.affecter');
    Route::post('/affectation/store', [AffectationController::class, 'store'])->name('affectation.store');

    // Routes pour la gestion des courriers
    Route::get('/courriers', [CourrierController::class, 'index'])->name('courriers.index');
    Route::get('/courriers/create', [CourrierController::class, 'create'])->name('courriers.create');
    Route::post('/courriers', [CourrierController::class, 'store'])->name('courriers.store');
    Route::get('/courriers/{courrier}/edit', [CourrierController::class, 'edit'])->name('courriers.edit');
    Route::patch('/courriers/{courrier}', [CourrierController::class, 'update'])->name('courriers.update');
    Route::delete('/courriers/{courrier}', [CourrierController::class, 'destroy'])->name('courriers.destroy');
    Route::post('/courriers/envoyer', [CourrierController::class, 'envoyer'])->name('courriers.envoyer');
    Route::post('/courriers/{courrier}/affecter', [CourrierController::class, 'affecter'])->name('courriers.affecter');

    // Afficher le détail d'un courrier
    Route::get('/courriers/{courrier}', [App\Http\Controllers\CourrierController::class, 'show'])->name('courriers.show');
});

// Afficher le détail d'un courrier pour le secrétaire
Route::get('/secretaire/courriers/{id}', [App\Http\Controllers\DashboardController::class, 'showCourrier'])->name('secretaire.courriers.show');

// Téléchargement des pièces jointes
Route::get('/pieces-jointes/{pieceJointe}/download', [CourrierController::class, 'download'])
    ->name('pieces-jointes.download')
    ->middleware('can:download,pieceJointe');

// Pour remplacer une pièce jointe
Route::patch('/pieces-jointes/{pieceJointe}', [PieceJointeController::class, 'update'])->name('pieces_jointes.update');
// Pour supprimer une pièce jointe
Route::delete('/pieces-jointes/{pieceJointe}', [PieceJointeController::class, 'destroy'])->name('pieces_jointes.destroy');


Route::patch('/notifications/{id}/read', function($id) {
    $notification = Auth::user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return back();
})->name('notifications.read')->middleware('auth');

// Supprimer une notification
Route::delete('/notifications/{id}', function($id) {
    $notification = auth::user()->notifications()->findOrFail($id);
    $notification->delete();
    return back();
})->name('notifications.delete')->middleware('auth');

// Supprimer une notification pour le secrétaire
Route::delete('/secretaire/notifications/{id}', function($id) {
    $notification = auth::user()->notifications()->findOrFail($id);
    $notification->delete();
    return back();
})->name('secretaire.notifications.delete')->middleware('auth');

Route::patch('/secretaire/notifications/{id}/read', function($id) {
    $notification = auth::user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return back();
})->name('secretaire.notifications.read')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Route pour tester l'envoi d'e-mails (désactivée)
|--------------------------------------------------------------------------
*/

// Route::get('/test-email', function () {
//     $details = [
//         'title' => 'Test Email from Laravel',
//         'body' => 'Ceci est un e-mail de test envoyé depuis Laravel.'
//     ];

//     Mail::raw($details['body'], function ($message) use ($details) {
//         $message->to('r.rykydiatta@gmail.com') // Remplacez par l'adresse e-mail du destinataire
//                 ->subject($details['title']);
//     });

//     return 'Email envoyé avec succès !';
// });

/*
|--------------------------------------------------------------------------
| Routes d'authentification (générées par Laravel Breeze/Jetstream)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';