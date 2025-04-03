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
        'pieces_jointes.*' => 'file|mimes:pdf,docx,jpg,png|max:2048'
    ]);

    try {
        $courrier = Courrier::create([
            'type' => $request->type,
            'reference_expediteur' => $request->reference_expediteur,
            'objet' => $request->objet,
            'date_reception' => $request->date_reception,
            'expediteur' => $request->expediteur,
            'description' => $request->description,
            'expediteur_id' => Auth::id(),
            'statut' => 'en_attente',
        ]);

        if ($request->hasFile('pieces_jointes')) {
            foreach ($request->file('pieces_jointes') as $file) {
                $path = $file->store('courriers', 'public');
                $courrier->documents()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('courriers.index')->with('success', 'Courrier créé avec succès !');
    } catch (\Exception $e) {
        return back()->with('error', 'Erreur lors de la création du courrier : ' . $e->getMessage());
    }
}

    
}
