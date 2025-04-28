<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\Service;
use App\Models\Affectation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AffectationController extends Controller
{
    /**
     * Affiche le formulaire d’affectation d’un courrier
     */
    public function create(Courrier $courrier)
    {
        $services = Service::all(); // On récupère les services disponibles

         // Récupérer les utilisateurs ayant le rôle "Agent"
    $agents = User::whereHas('role', function ($query) {
        $query->where('name', 'Agent');
    })->get();

        return view('affectation.create', compact('courrier', 'services', 'agents'));
    }

    /**
     * Enregistre une affectation
     */
    public function store(Request $request)
    {
        $request->validate([
            'courrier_id' => 'required|exists:courriers,id',
            'service_id' => 'required|exists:services,id',
            'observation' => 'nullable|string|max:1000',
        ]);

        try {
            Affectation::create([
                'courrier_id' => $request->courrier_id,
                'service_id' => $request->service_id,
                'observation' => $request->observation,
                'statut' => 'non_lu',
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('courriers.index')->with('success', '✅ Courrier affecté avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Erreur lors de l\'affectation : ' . $e->getMessage());
        }
    }
}
