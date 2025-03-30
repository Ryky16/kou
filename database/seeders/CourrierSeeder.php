<?php

namespace Database\Seeders;

use App\Models\Courrier;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourrierSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            $services = Service::all();
            $admin = User::where('email', 'n.henripierre@gmail.com')->firstOrFail();
            $secretaire = User::where('email', 'secretaire@gmail.com')->firstOrFail();
            $agent = User::where('email', 'agent@gmail.com')->firstOrFail();

            // 1. Courrier entrant (expéditeur externe)
            Courrier::create([
                'reference' => 'EXT-' . now()->format('YmdHis'),
                'objet' => 'Demande de permis de construire',
                'contenu' => 'Projet de construction maison',
                'type' => 'entrant',
                'expediteur_id' => $secretaire->id, // Modifié: ne peut pas être null
                'destinataire_id' => $agent->id,
                'service_id' => $services->where('nom', 'Service Urbanisme')->first()->id,
                'statut' => 'envoyé', // Modifié: doit être 'brouillon', 'envoyé' ou 'traité'
                'priorite' => 'moyenne', // Modifié: doit être 'basse', 'moyenne' ou 'haute'
                'date_reception' => now(),
                'created_by' => $secretaire->id
            ]);

            // 2. Courrier interne
            Courrier::create([
                'reference' => 'MAIRIE-' . now()->format('YmdHis'),
                'objet' => 'Demande de matériel',
                'contenu' => 'Commande de fournitures',
                'type' => 'interne',
                'expediteur_id' => $secretaire->id,
                'destinataire_id' => $admin->id,
                'service_id' => $services->where('nom', 'Secrétariat Municipal')->first()->id,
                'statut' => 'envoyé',
                'priorite' => 'haute',
                'date_reception' => now(),
                'created_by' => $secretaire->id
            ]);

            // 3. Courrier sortant
            Courrier::create([
                'reference' => 'SORT-' . now()->format('YmdHis'),
                'objet' => 'Réponse à demande',
                'contenu' => 'Accord de subvention',
                'type' => 'sortant',
                'expediteur_id' => $secretaire->id,
                'destinataire_id' => null, // Peut être null pour les sortants
                'service_id' => $services->where('nom', 'Service Finances')->first()->id,
                'statut' => 'traité',
                'priorite' => 'moyenne', // 'normale' n'existe pas dans votre enum
                'date_reception' => now()->subDays(2),
                'created_by' => $secretaire->id
            ]);
        });
    }
}