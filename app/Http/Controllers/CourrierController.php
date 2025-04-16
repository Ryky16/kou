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
        $courriers = Courrier::with(['expediteur', 'destinataire'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('courriers.index', compact('courriers'));
    }
                    
    public function create()
    {
        $secretaires = User::whereHas('role', function($query) {
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
            // Traitement du destinataire
            $destinataireData = $this->processDestinataire($validated['destinataire_id']);
            
            // Création du courrier
            $courrierData = [
                'type' => $validated['type'],
                'nature' => $validated['nature'] ?? null,
                'reference' => $validated['reference'],
                'objet' => $validated['objet'],
                'contenu' => $validated['description'] ?? null,
                'date_reception' => $validated['date_reception'],
                'expediteur_id' => Auth::id(),
                'statut' => $validated['statut'] ?? 'brouillon',
                'priorite' => $validated['priorite'] ?? 'moyenne',
                'created_by' => Auth::id(),
            ];

            // Gestion des différents types de destinataires
            if ($validated['destinataire_id'] === 'autre') {
                $courrierData['email_destinataire'] = $validated['email_destinataire'];
            } elseif (str_starts_with($validated['destinataire_id'], 'service_')) {
                $serviceId = str_replace('service_', '', $validated['destinataire_id']);
                $courrierData['service_id'] = $serviceId;
            } else {
                $courrierData['destinataire_id'] = $validated['destinataire_id'];
            }

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
                        'courrier_id' => $courrier->id
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('courriers.index')
                ->with('success', 'Courrier ajouté avec succès !');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Erreur de base de données: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Erreur lors de l\'ajout du courrier: ' . $e->getMessage());
        }
    }

    /**
     * Vérifie que le destinataire existe
     */
    protected function processDestinataire($destinataireInput)
    {
        if ($destinataireInput === 'autre') {
            return; // Pas de vérification pour les destinataires externes
        }

        if (str_starts_with($destinataireInput, 'service_')) {
            $serviceId = str_replace('service_', '', $destinataireInput);
            if (!Service::find($serviceId)) {
                throw new \Exception("Le service sélectionné n'existe pas");
            }
        } else {
            if (!User::find($destinataireInput)) {
                throw new \Exception("Le destinataire sélectionné n'existe pas");
            }
        }
    }
}