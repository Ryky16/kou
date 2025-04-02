<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\Service;
use App\Models\User;

class AffectationController extends Controller
{
    /**
     * Afficher la page d'affectation des courriers.
     */
    public function index()
    {
        $courriers = Courrier::where('statut', 'en_attente')->get(); // Récupère les courriers non affectés
        $services = Service::all(); // Récupère tous les services
        $agents = User::whereHas('role', function ($query) {
            $query->where('name', 'Agent'); // Récupère uniquement les utilisateurs ayant le rôle "Agent"
        })->get();

        return view('affectation.index', compact('courriers', 'services', 'agents'));
    }

    /**
     * Affecter un courrier à un agent ou un service.
     */
    public function affecter(Request $request)
    {
        $request->validate([
            'courrier_id' => 'required|exists:courriers,id',
            'service_id' => 'nullable|exists:services,id',
            'agent_id' => 'nullable|exists:users,id',
        ]);

        $courrier = Courrier::findOrFail($request->courrier_id);

        if ($request->service_id) {
            $courrier->service_id = $request->service_id;
        }

        if ($request->agent_id) {
            $courrier->user_id = $request->agent_id;
        }

        $courrier->statut = 'affecté';
        $courrier->save();

        return redirect()->back()->with('success', 'Courrier affecté avec succès !');
    }
}
