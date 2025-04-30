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

        // Récupérer les courriers en fonction du rôle de l'utilisateur
        $query = Courrier::with(['expediteur', 'destinataire', 'service'])->orderBy('created_at', 'desc');

        if ($user->hasRole('Secretaire_Municipal')) {
            // Le secrétaire municipal voit uniquement les courriers en brouillon
            $query->where('statut', 'brouillon');
        } elseif ($user->hasRole('Agent')) {
            // L'agent voit les courriers qui lui sont affectés
            $query->where('destinataire_id', $user->id);
        }

        $courriers = $query->get();

        // Afficher la vue correspondante
        return view($user->hasRole('Secretaire_Municipal') ? 'courriers.secretaire.index' : 'courriers.agent.index', compact('courriers'));
    }

    public function envoyer(Request $request)
    {
        $request->validate([
            'courrier_id' => 'required|exists:courriers,id',
        ]);

        $courrier = Courrier::findOrFail($request->courrier_id);
        $courrier->statut = 'envoyé';
        $courrier->save();

        return redirect()->back()->with('success', 'Le courrier a été envoyé avec succès.');
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
}