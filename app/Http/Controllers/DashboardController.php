<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Courrier;
use App\Models\User;
use App\Models\Service;

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
    public function secretaire(Request $request)
    {
        $query = Courrier::with(['expediteur', 'destinataire', 'service', 'piecesJointes']);

        if ($search = $request->input('q')) {
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%$search%")
                  ->orWhere('objet', 'like', "%$search%")
                  ->orWhereDate('date_reception', $search)
                  ->orWhereHas('expediteur', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
                  })
                  ->orWhereHas('destinataire', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
                  })
                  ->orWhereHas('service', function($q2) use ($search) {
                      $q2->where('nom', 'like', "%$search%");
                  })
                  ->orWhere('email_destinataire', 'like', "%$search%");
            });
        }

        $courriers = $query->latest()->paginate(10);
        $notifications = Auth::user()->unreadNotifications;
        $totalCourriers = Courrier::count();
        $courriersAffectes = Courrier::where('statut', 'envoyé')->count();
        $courriersEnAttente = Courrier::where('statut', 'brouillon')->count();
       
        $agents = User::whereHas('role', function ($query) {
            $query->where('name', 'Agent');
        })->get();

        $services = Service::all();

        return view('dashboard.secretaire', compact(
            'courriers', 
            'notifications', 
            'totalCourriers',
            'courriersAffectes',
            'courriersEnAttente',
            'agents',
            'services'
            ));
    }

    // Vue pour l'agent
    public function agent(Request $request)
    {
        $query = Courrier::with(['expediteur', 'destinataire', 'service', 'piecesJointes'])
            ->where('expediteur_id', Auth::id());

        if ($search = $request->input('q')) {
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%$search%")
                  ->orWhere('objet', 'like', "%$search%")
                  ->orWhereDate('date_reception', $search)
                  ->orWhereHas('expediteur', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
                  })
                  ->orWhereHas('destinataire', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
                  })
                  ->orWhereHas('service', function($q2) use ($search) {
                      $q2->where('nom', 'like', "%$search%");
                  })
                  ->orWhere('email_destinataire', 'like', "%$search%");
            });
        }

        $courriers = $query->latest()->paginate(10);
        $notifications = Auth::user()->unreadNotifications;
        $totalCourriers = Courrier::count();
        $totalAffectes = Courrier::where('statut', 'envoyé')->count();
        $totalEnAttente = Courrier::where('statut', 'brouillon')->count();

        return view('dashboard.agent', compact('courriers', 'notifications', 'totalCourriers', 'totalAffectes', 'totalEnAttente'));
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

        return view('dashboard.agent', compact('courriers'));
    }
}