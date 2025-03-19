<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Redirection en fonction du rôle
    public function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->hasRole('Administrateur')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('Secretaire_Municipal')) {
            return redirect()->route('secretaire.dashboard');
        } elseif ($user->hasRole('Agent')) {
            return redirect()->route('agent.dashboard');
        }

        // Redirection par défaut si le rôle n'est pas reconnu
        return redirect('/');
    }

    // Vue pour l'administrateur
    public function admin()
    {
        return view('dashboard.admin'); // Chemin correct
    }

    // Vue pour le secrétaire municipal
    public function secretaire()
    {
        return view('dashboard.secretaire'); // Chemin correct
    }

    // Vue pour l'agent
    public function agent()
    {
        return view('dashboard.agent'); // Chemin correct
    }
}