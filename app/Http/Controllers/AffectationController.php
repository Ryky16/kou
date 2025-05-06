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
            'email_destinataire' => 'required|email', // Adresse e-mail obligatoire
            'observation' => 'nullable|string|max:1000',
        ]);

        try {
            $courrier = Courrier::findOrFail($request->courrier_id);

            // Affecter le courrier
            if ($request->destinataire_type === 'service') {
                $courrier->service_id = $request->destinataire_id;
            }

            $courrier->email_destinataire = $request->email_destinataire;
            $courrier->statut = 'Affecté'; // Mise à jour du statut
            $courrier->save();

            // Enregistrer l'affectation
            Affectation::create([
                'courrier_id' => $courrier->id,
                'user_id' => null, // Pas d'utilisateur direct pour les services ou e-mails
                'statut' => 'non_lu',
                'created_by' => Auth::id(),
                'observation' => $request->observation,
            ]);

            // Envoyer un e-mail au destinataire
            Mail::to($request->email_destinataire)->send(new CourrierAffecte($courrier));

            return redirect()->route('courriers.index')->with('success', '✅ Courrier affecté avec succès et envoyé par e-mail !');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Erreur lors de l\'affectation : ' . $e->getMessage());
        }
    }
}
