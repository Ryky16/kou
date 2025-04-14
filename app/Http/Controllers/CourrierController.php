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

    public function index()
    {
        // Récupérer tous les courriers
        $courriers = Courrier::with(['expediteur', 'destinataire'])->orderBy('created_at', 'desc')->get();

        // Retourner la vue avec les courriers
        return view('courriers.index', compact('courriers'));
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
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour ajouter un courrier.');
        }

        // Validez les données du formulaire
        $validated = $request->validate([
            'type' => 'required|string',
            'nature' => 'nullable|string|max:50',
            'reference' => 'required|string|unique:courriers,reference',
            'objet' => 'required|string',
            'date_reception' => 'required|date',
            'expediteur_id' => 'required|exists:users,id',
            'destinataire_id' => 'nullable|string',
            'description' => 'nullable|string',
            'statut' => 'nullable|string|in:brouillon,envoyé,traité', // Validation stricte pour statut
            'priorite' => 'nullable|string|in:basse,moyenne,haute',
            'pieces_jointes.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
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
                'statut' => $validated['statut'] ?? 'brouillon', // Valeur par défaut
                'priorite' => $validated['priorite'] ?? 'moyenne', // Valeur par défaut
                'created_by' => Auth::id(), // Ajoutez l'utilisateur connecté
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

            // Redirigez avec un message de succès
            return redirect()->route('courriers.index')->with('success', 'Courrier ajouté avec succès !');
        } catch (\Exception $e) {
            // Retournez au formulaire avec un message d'erreur
            return back()->with('error', 'Erreur lors de l\'ajout du courrier : ' . $e->getMessage());
        }
    }
}
