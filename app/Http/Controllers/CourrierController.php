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
        $agents = User::where('role_id', 2)->get(); // Exemple : rôle_id = 2 pour les agents

        return view('courriers.create', compact('agents'));
    }

    public function store(Request $request)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }

        $request->validate([
            'type' => 'required|string',
            'reference_expediteur' => 'required|string|unique:courriers,reference_expediteur',
            'objet' => 'required|string',
            'date_reception' => 'required|date',
            'expediteur' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Création du courrier
        Courrier::create([
            'type' => $request->type,
            'reference_expediteur' => $request->reference_expediteur,
            'objet' => $request->objet,
            'date_reception' => $request->date_reception,
            'expediteur' => $request->expediteur,
            'description' => $request->description,
            'expediteur_id' => Auth::id(), // Vérifie bien que l'utilisateur est connecté
            'statut' => 'en_attente',
        ]);

        return redirect()->route('courriers.index')->with('success', 'Courrier créé avec succès !');
    }
}
