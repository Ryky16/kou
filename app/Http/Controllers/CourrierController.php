<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\User;
use App\Models\PieceJointe;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CourrierController extends Controller
{
    public function download(PieceJointe $pieceJointe)
    {
        $filePath = Storage::disk('public')->path($pieceJointe->chemin);
        return response()->download($filePath, $pieceJointe->nom_original);
    }

    public function index()
    {
        $user = Auth::user();

        // Récupérer tous les courriers pour les deux rôles
        $query = Courrier::with(['expediteur', 'destinataire', 'service'])->orderBy('created_at', 'desc');

        // Si l'utilisateur est un secrétaire municipal, il voit tous les courriers
        if ($user->hasRole('Secretaire_Municipal')) {
            $courriers = $query->get();
            return view('courriers.secretaire.index', compact('courriers'));
        }

        // Si l'utilisateur est un agent, il voit les courriers qu'il a ajoutés ou qui lui sont affectés
        if ($user->hasRole('Agent')) {
            $query->where(function ($q) use ($user) {
                $q->where('expediteur_id', $user->id) // Courriers ajoutés par l'agent
                  ->orWhere('destinataire_id', $user->id) // Courriers affectés à l'agent
                  ->orWhereNull('destinataire_id'); // Courriers non affectés (ajoutés par le secrétaire municipal)
            });
            $courriers = $query->get();
            return view('courriers.agent.index', compact('courriers'));
        }
    }

    public function envoyer(Request $request)
    {
        $request->validate([
            'courrier_id' => 'required|exists:courriers,id',
        ]);

        $courrier = Courrier::findOrFail($request->courrier_id);

        // Envoyer uniquement au secrétaire municipal
        $secretaire = User::whereHas('role', function ($query) {
            $query->where('name', 'Secretaire_Municipal');
        })->first();

        if ($secretaire) {
            $courrier->destinataire_id = $secretaire->id;
            $courrier->statut = 'envoyé';
            $courrier->save();

            return redirect()->back()->with('success', 'Le courrier a été envoyé au secrétaire municipal avec succès.');
        }

        return redirect()->back()->with('error', 'Aucun secrétaire municipal trouvé.');
    }

    public function create()
    {
        $secretaires = User::whereHas('role', function ($query) {
            $query->where('name', 'Secretaire_Municipal');
        })->get();

        $agents = User::whereHas('role', function ($query) {
            $query->where('name', 'Agent');
        })->get();

        $services = Service::all();

        return view('courriers.create', compact('agents', 'services', 'secretaires'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour ajouter un courrier.');
        }

        $validated = $request->validate([
            'type' => ['required', 'string', Rule::in(['entrant', 'sortant', 'interne'])],
            'nature' => 'nullable|string|max:50',
            'reference' => 'required|string|unique:courriers,reference',
            'objet' => 'required|string|max:255',
            'date_reception' => 'required|date',
            'destinataire_id' => 'required|string',
            'email_destinataire' => 'nullable|required_if:destinataire_id,autre|email',
            'description' => 'nullable|string',
            'statut' => 'nullable|string|in:brouillon,envoyé,traité',
            'priorite' => 'nullable|string|in:basse,moyenne,haute',
            'pieces_jointes.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        DB::beginTransaction();

        try {
            // Création des données du courrier
            $courrierData = [
                'type' => $validated['type'],
                'nature' => $validated['nature'],
                'reference' => $validated['reference'],
                'objet' => $validated['objet'],
                'contenu' => $validated['description'],
                'date_reception' => $validated['date_reception'],
                'expediteur_id' => Auth::id(),
                'statut' => $validated['statut'] ?? 'brouillon',
                'priorite' => $validated['priorite'] ?? 'moyenne',
                'created_by' => Auth::id(),
                'destinataire_id' => null,
                'service_id' => null,
                'email_destinataire' => null,
            ];

            // Gestion spécifique du destinataire
            if ($validated['destinataire_id'] === 'autre') {
                $courrierData['email_destinataire'] = $validated['email_destinataire'];
            } elseif (str_starts_with($validated['destinataire_id'], 'service_')) {
                $courrierData['service_id'] = str_replace('service_', '', $validated['destinataire_id']);
            } else {
                $courrierData['destinataire_id'] = $validated['destinataire_id'];
            }

            // Enregistrement du courrier
            $courrier = Courrier::create($courrierData);

            // Gestion des pièces jointes
            if ($request->hasFile('pieces_jointes')) {
                foreach ($request->file('pieces_jointes') as $file) {
                    $path = $file->store('pieces_jointes', 'public');
                    PieceJointe::create([
                        'chemin' => $path,
                        'nom_original' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'taille' => $file->getSize(),
                        'courrier_id' => $courrier->id,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('courriers.index')
                ->with('success', 'Courrier ajouté avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Erreur lors de l\'ajout du courrier: ' . $e->getMessage());
        }
    }

    public function edit(Courrier $courrier)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est l'expéditeur, le destinataire ou un agent
        if ($courrier->expediteur_id !== $user->id && $courrier->destinataire_id !== $user->id && !$user->hasRole('Agent')) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce courrier.');
        }

        $services = Service::all();
        return view('courriers.edit', compact('courrier', 'services'));
    }

    public function update(Request $request, $id)
    {
        $courrier = \App\Models\Courrier::findOrFail($id);

        $request->validate([
            'type' => 'required',
            'nature' => 'required',
            'reference' => 'required',
            'objet' => 'required',
            'description' => 'required',
            'date_reception' => 'nullable|date',
            'priorite' => 'required',
            'pieces_jointes.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
        ]);

        $courrier->update([
            'type' => $request->type,
            'nature' => $request->nature,
            'reference' => $request->reference,
            'objet' => $request->objet,
            'contenu' => $request->description,
            'date_reception' => $request->date_reception,
            'priorite' => $request->priorite,
        ]);

        // Ajout de nouvelles pièces jointes
        if ($request->hasFile('pieces_jointes')) {
            foreach ($request->file('pieces_jointes') as $file) {
                $chemin = $file->store('pieces_jointes', 'public');
                $courrier->piecesJointes()->create([
                    'nom_original' => $file->getClientOriginalName(),
                    'chemin' => $chemin,
                    'mime_type' => $file->getClientMimeType(),
                    'taille' => $file->getSize(),
                ]);
            }
        }

        // Redirection vers le dashboard agent après modification
        return redirect()->route('agent.dashboard')
            ->with('success', 'Courrier modifié avec succès.');
    }

    public function destroy(Courrier $courrier)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est l'expéditeur, le destinataire ou un agent
        if ($courrier->expediteur_id !== $user->id && $courrier->destinataire_id !== $user->id && !$user->hasRole('Agent')) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce courrier.');
        }

        $courrier->delete();

        return redirect()->route('courriers.index')
            ->with('success', 'Courrier supprimé avec succès.');
    }

    public function affecter(Courrier $courrier)
    {
        try {
            // Vérifier si le courrier a une adresse e-mail de destinataire
            if (!$courrier->email_destinataire) {
                return back()->with('error', '❌ Ce courrier n\'a pas d\'adresse e-mail de destinataire.');
            }

            // Envoyer l'e-mail avec les pièces jointes
            Mail::send('emails.courrier_affecte', compact('courrier'), function ($message) use ($courrier) {
                $message->to($courrier->email_destinataire)
                        ->subject('📩 Courrier Affecté - Réf : ' . $courrier->reference);

                foreach ($courrier->piecesJointes as $pieceJointe) {
                    $message->attach(storage_path('app/public/' . $pieceJointe->chemin), [
                        'as' => $pieceJointe->nom_original,
                        'mime' => $pieceJointe->mime_type,
                    ]);
                }
            });

            // Mettre à jour le statut du courrier
            $courrier->statut = 'Affecté';
            $courrier->save();

            return back()->with('success', '✅ Courrier affecté avec succès à ' . $courrier->email_destinataire);
        } catch (\Exception $e) {
            // Journaliser l'erreur
            Log::error('Erreur lors de l\'affectation : ' . $e->getMessage());

            return back()->with('error', '❌ Une erreur est survenue : ' . $e->getMessage());
        }
    }
}