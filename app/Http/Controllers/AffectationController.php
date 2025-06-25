<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\Service;
use App\Models\Affectation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\CourrierAffecte;
use Carbon\Carbon;

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
            'destinataire_id' => 'required|string',
            'email_destinataire' => 'required|email',
            'observation' => 'nullable|string|max:1000',
        ]);

        try {
            $courrier = Courrier::findOrFail($request->courrier_id);

            if (str_starts_with($request->destinataire_id, 'service_')) {
                $courrier->service_id = str_replace('service_', '', $request->destinataire_id);
                $courrier->destinataire_id = null;
            } elseif ($request->destinataire_id === 'autre') {
                $courrier->service_id = null;
                $courrier->destinataire_id = null;
            } else {
                $courrier->destinataire_id = $request->destinataire_id;
                $courrier->service_id = null;
            }
            $courrier->email_destinataire = $request->email_destinataire;
            $courrier->statut = 'envoyé';
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
            $body = "📩 Nouveau Courrier Affecté\n\nBonjour,\n\nUn nouveau courrier vous a été affecté par le Secrétaire Municipal de la Mairie de Ziguinchor. Voici les détails :\n\n";
            $body .= "Référence : {$courrier->reference}\n";
            $body .= "Objet : {$courrier->objet}\n";
            $body .= "Contenu : {$courrier->contenu}\n";
            $body .= "Date de réception : " . ($courrier->date_reception ? Carbon::parse($courrier->date_reception)->format('d/m/Y') : '-') . "\n";
            $body .= "📎 Merci de vérifier les pièces jointes pour plus de détails.\n\nCordialement,\n\nSecrétaire Municipal\nMairie de Ziguinchor";

            Mail::send([], [], function ($message) use ($request, $body, $courrier) {
                $message->to($request->email_destinataire)
                        ->subject('📩 Nouveau Courrier Affecté')
                        ->html(nl2br($body)); 
                foreach ($courrier->piecesJointes as $piece) {
                    $message->attach(storage_path('app/public/' . $piece->chemin), [
                        'as' => $piece->nom_original,
                        'mime' => $piece->mime_type,
                    ]);
                }
            });
            Log::info('Email envoyé à ' . $request->email_destinataire);

            return redirect()->route('secretaire.dashboard')->with('success', '✅ Courrier affecté avec succès à ' . $request->email_destinataire);
        } catch (\Exception $e) {
            // Journaliser l'erreur
            Log::error('Erreur lors de l\'affectation : ' . $e->getMessage());

            return back()->with('error', '❌ Une erreur est survenue : ' . $e->getMessage());
        }
    }
}
