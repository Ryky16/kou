<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\Service;
use App\Models\Affectation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourrierAffecte;

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
            'email_destinataire' => 'required|email', // Adresse e-mail obligatoire
            'observation' => 'nullable|string|max:1000',
        ]);

        try {
            $courrier = Courrier::findOrFail($request->courrier_id);

            // Affecter l'adresse e-mail au courrier
            $courrier->email_destinataire = $request->email_destinataire;
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

            // Envoyer un e-mail au destinataire
            Mail::to($request->email_destinataire)->send(new CourrierAffecte($courrier));

            return redirect()->route('courriers.index')->with('success', '✅ Courrier affecté avec succès à ' . $request->email_destinataire);
        } catch (\Exception $e) {
            return back()->with('error', '❌ Erreur lors de l\'affectation : ' . $e->getMessage());
        }
    }
}
