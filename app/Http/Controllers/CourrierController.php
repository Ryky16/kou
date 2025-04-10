<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourrierController extends Controller
{
    public function create()
    {
        // Récupérer les agents disponibles
        //$agents = User::where('role_id', 2)->get(); // Exemple : rôle_id = 2 pour les agents

        $agents = User::whereHas('role', function ($query) {
            $query->where('name', 'Agent');
        })->get();
        
        return view('courriers.create', compact('agents'));
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
            'expediteur' => 'required|string',
            'description' => 'nullable|string',
            'pieces_jointes.*' => 'file|mimes:pdf,docx,jpg,png|max:2048'
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
                'expediteur_id' => Auth::id(), // L'utilisateur connecté est l'expéditeur
                'statut' => 'En attente', // Par défaut
                'priorite' => 'moyenne', // Par défaut
            ]);

            // Gérer les pièces jointes
            if ($request->hasFile('pieces_jointes')) {
                foreach ($request->file('pieces_jointes') as $file) {
                    $path = $file->store('courriers', 'public');
                    $courrier->documents()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            // Redirigez vers le tableau de suivi avec un message de succès
            return redirect()->route('secretaire.dashboard')->with('success', 'Courrier ajouté avec succès !');
        } catch (\Exception $e) {
            // En cas d'erreur, retournez au formulaire avec un message d'erreur
            return back()->with('error', 'Erreur lors de la création du courrier : ' . $e->getMessage());
        }
    }
}
