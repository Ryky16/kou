<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Courrier;

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
        $courriers = Courrier::latest()->paginate(10); // ou selon la logique métier
        $notifications = Auth::user()->unreadNotifications;
        
        $totalCourriers = Courrier::count();
        $courriersAffectes = Courrier::where('statut', 'envoyé')->count();
        $courriersEnAttente = Courrier::where('statut', 'brouillon')->count();
       
    return view('dashboard.secretaire', 
        compact('courriers', 
                'notifications', 
                'totalCourriers',
                'courriersAffectes',
                'courriersEnAttente'
                ));
    }

    // Vue pour l'agent
    public function agent()
    {
        $courriers = Courrier::where('expediteur_id', Auth::id())->latest()->paginate(10);
        $notifications = auth::user()->unreadNotifications;

         // Statistiques globales (pas seulement pour l'agent)
    $totalCourriers = Courrier::count();
    $totalAffectes = Courrier::where('statut', 'envoyé')->count();
    $totalEnAttente = Courrier::where('statut', 'brouillon')->count();

        return view('dashboard.agent', compact('courriers', 
                    'notifications', 
                    'totalCourriers',
                    'totalAffectes',
                    'totalEnAttente'));
    }

    public function showCourrier($id)
    {
        $courrier = \App\Models\Courrier::with('expediteur', 'destinataire', 'service', 'piecesJointes')->findOrFail($id);
        return view('courriers.show', compact('courrier'));
    }

    // Archives pour l'agent
    public function archives()
    {
        $courriers = Courrier::where('statut', 'archivé')
            ->where(function($q) {
                $q->where('expediteur_id', Auth::id())
                  ->orWhere('destinataire_id', Auth::id());
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('agent.archives', compact('courriers'));
    }
}