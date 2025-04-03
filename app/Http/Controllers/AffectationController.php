<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AffectationController extends Controller
{
    public function index()
    {
        // Récupérer les expéditeurs (par exemple, les utilisateurs ayant un rôle spécifique)
        $expediteurs = User::whereHas('role', function ($query) {
            $query->where('name', 'Expéditeur');
        })->get();

        // Récupérer les destinataires (par exemple, les agents ou autres utilisateurs)
        $destinataires = User::whereHas('role', function ($query) {
            $query->where('name', 'Agent');
        })->get();

        // Récupérer les courriers
        $courriers = Courrier::all();

        // Transmettre les données à la vue
        return view('affectation.index', compact('expediteurs', 'destinataires', 'courriers'));
    }

    public function affecter(Request $request)
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }

        // Validation des données du formulaire
        $request->validate([
            /*'type' => 'required|string',
            'reference_expediteur' => 'required|string|unique:courriers,reference_expediteur',
            'objet' => 'required|string',
            'date_reception' => 'required|date',
            'expediteur' => 'required|string',
            'description' => 'nullable|string',
            'pieces_jointes.*' => 'file|max:10240',*/ // 10 Mo max par fichier
        
        ]);

        try {
            // Création du courrier
            $courrier = Courrier::create([
                'type' => $request->type,
                'reference_expediteur' => $request->reference_expediteur,
                'objet' => $request->objet,
                'date_reception' => $request->date_reception,
                'expediteur' => $request->expediteur,
                'description' => $request->description,
                'statut' => 'en_attente',
            ]);

            // Vérification et enregistrement des fichiers joints
            if ($request->hasFile('pieces_jointes')) {
                foreach ($request->file('pieces_jointes') as $file) {
                    $path = $file->store('courriers', 'public');

                    Document::create([
                        'courrier_id' => $courrier->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                    ]);
                }
            }

            return redirect()->route('courriers.index')->with('success', 'Courrier créé avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
}
