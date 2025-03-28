<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\CourrierLog;
use Illuminate\Support\Facades\Auth;

class CourrierController extends Controller
{
    // Afficher la liste des courriers
    public function index()
{
    $courriers = Courrier::paginate(10); // 10 courriers par page
    return view('dashboard.secretaire', compact('courriers'));
}

    public function affecter(Request $request)
    {
        $request->validate([
            'courrier_id' => 'required|exists:courriers,id',
            'user_id' => 'required|exists:users,id', // L'agent qui reçoit
        ]);

        $courrier = Courrier::findOrFail($request->courrier_id);

        if ($courrier->statut === 'affecté') {
            return response()->json([
                'success' => false,
                'message' => 'Ce courrier a déjà été affecté.'
            ], 400);
        }

        // Mise à jour du statut et de l'affectation
        $courrier->update([
            'statut' => 'affecté',
            'user_id' => $request->user_id,
        ]);

        // Ajout de l'affectation dans le journal des logs
        CourrierLog::create([
            'courrier_id' => $courrier->id,
            'user_id' => Auth::id(), // L’utilisateur qui fait l'affectation
            'agent_id' => $request->user_id, // L’agent à qui on affecte
            'action' => 'affectation',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Courrier affecté avec succès !'
        ]);
    }
}
