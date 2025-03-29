<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier; // Assure-toi que ce modèle existe
use Illuminate\Support\Facades\DB;

class AffectationController extends Controller
{
    public function affecter(Request $request)
    {
        $request->validate([
            'courrier_id' => 'required|exists:courriers,id'
        ]);

        // Récupérer le courrier et mettre à jour son statut
        $courrier = Courrier::findOrFail($request->courrier_id);
        $courrier->statut = 'Affecté';
        $courrier->save();

        return redirect()->back()->with('success', 'Le courrier a été affecté avec succès !');
    }
}
