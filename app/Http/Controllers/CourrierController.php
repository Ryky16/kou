<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\PieceJointe;
use Illuminate\Support\Facades\Storage;

class CourrierController extends Controller
{
    public function download(PieceJointe $pieceJointe)
    {
        // Vérifie automatiquement les permissions via la politique
        $filePath = Storage::disk('public')->path($pieceJointe->chemin);
        return response()->download($filePath, $pieceJointe->nom_original);
    }

    public function create()
    {
        // Récupérer les agents disponibles
        //$agents = User::where('role_id', 2)->get(); // Exemple : rôle_id = 2 pour les agents

        $agents = User::whereHas('role', function ($query) {
            $query->where('name', 'Agent');
        })->get();

        // Récupérer les services disponibles
    $services = \App\Models\Service::all(); // Assurez-vous que le modèle Service existe
        
        return view('courriers.create', compact('agents', 'services'));
    }

    public function store(Request $request)
    {
        // Vérifiez si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }

        // Validez les données du formulaire
        $validated = $request->validate([
            'type' => 'required|string',
            'nature' => 'nullable|string|max:50',
            'reference' => 'required|string|unique:courriers,reference',
            'objet' => 'required|string',
            'date_reception' => 'required|date',
            'expediteur_id' => 'required|exists:users,id',
            'destinataire_id' => 'nullable|string', // Peut être un agent, un service ou autre
            'description' => 'nullable|string',
            'pieces_jointes.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png', // Max 10MB, formats autorisés
        ]);

        try {
            // Créez un nouveau courrier
            $courrier = Courrier::create([
                'type' => $validated['type'],
                'nature' => $validated['nature'] ?? null,
                'reference' => $validated['reference'],
                'objet' => $validated['objet'],
                'contenu' => $validated['description'] ?? null,
                'date_reception' => $validated['date_reception'],
                'expediteur_id' => $validated['expediteur_id'],
                'destinataire_id' => $validated['destinataire_id'] ?? null,
                'statut' => 'En attente', // Par défaut
                'priorite' => 'moyenne', // Par défaut
            ]);

            // Gérer les pièces jointes
            if ($request->hasFile('pieces_jointes')) {
                foreach ($request->file('pieces_jointes') as $file) {
                    $path = $file->store('pieces_jointes', 'public');
                    PieceJointe::create([
                        'chemin' => $path,
                        'nom_original' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'taille' => $file->getSize(),
                        'courrier_id' => $courrier->id
                    ]);
                }
            }

            return redirect()->route('courriers.index')
                ->with('success', 'Courrier créé avec succès!');

            // Redirigez vers le tableau de suivi avec un message de succès
            return redirect()->route('secretaire.dashboard')->with('success', 'Courrier ajouté avec succès !');
        } catch (\Exception $e) {
            // En cas d'erreur, retournez au formulaire avec un message d'erreur
            return back()->with('error', 'Erreur lors de la création du courrier : ' . $e->getMessage());
        }
    }
}
