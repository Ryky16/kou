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
        $services = Service::all(); // Récupérer les services disponibles
        $agents = User::whereHas('role', function ($query) {
            $query->where('name', 'Agent');
        })->get(); // Récupérer les agents

        return view('affectation.create', compact('courrier', 'services', 'agents'));
    }

    /**
     * Enregistre une affectation
     */
    public function store(Request $request)
    {
        $request->validate([
            'courrier_id' => 'required|exists:courriers,id',
            'destinataire_type' => 'required|in:agent,service,email',
            'destinataire_id' => 'nullable|integer',
            'email_destinataire' => 'nullable|email|required_if:destinataire_type,email',
            'observation' => 'nullable|string|max:1000',
        ]);

        try {
            $courrier = Courrier::findOrFail($request->courrier_id);

            // Affecter le courrier en fonction du type de destinataire
            if ($request->destinataire_type === 'agent') {
                $courrier->destinataire_id = $request->destinataire_id;
                $courrier->service_id = null;
                $courrier->email_destinataire = null;
            } elseif ($request->destinataire_type === 'service') {
                $courrier->service_id = $request->destinataire_id;
                $courrier->destinataire_id = null;
                $courrier->email_destinataire = null;
            } elseif ($request->destinataire_type === 'email') {
                $courrier->email_destinataire = $request->email_destinataire;
                $courrier->destinataire_id = null;
                $courrier->service_id = null;
            }

            $courrier->statut = 'Affecté'; // Mettre à jour le statut
            $courrier->save();

            // Enregistrer l'affectation
            Affectation::create([
                'courrier_id' => $courrier->id,
                'user_id' => $request->destinataire_id ?? null,
                'statut' => 'non_lu',
                'created_by' => Auth::id(),
                'observation' => $request->observation,
            ]);

            return redirect()->route('courriers.index')->with('success', '✅ Courrier affecté avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Erreur lors de l\'affectation : ' . $e->getMessage());
        }
    }
}
