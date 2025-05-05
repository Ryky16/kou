<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        // Récupère le secrétaire municipal (role_id = 2)
        $secretaire = User::where('role_id', 2)->first();

        $agent = User::where('role_id', 3)->first();

        // Services de base pour la mairie sénégalaise
        $services = [
            [
                'nom' => 'Secrétariat Municipal',
                'description' => 'Service central de gestion administrative',
                'responsable_id' => $secretaire ? $secretaire->id : null,
                'email' => 'secretariat@gmail.com',
                'telephone' => '+221 33 987 65 43', // Format Sénégal
            ],
            [
                'nom' => 'Services Techniques Communaux',
                'description' => 'Gestion des permis de construire et documents d\'urbanisme',
                'responsable_id' => null,
                'email' => 'urbanisme@gmail.com',
                'telephone' => '+221 33 123 45 67',
            ],
            [
                'nom' => 'Service État Civil',
                'description' => 'Gestion des naissances, mariages et décès',
                'responsable_id' => null,
                'email' => 'etatcivil@gmail.com',
                'telephone' => '+221 33 765 43 21',
            ],
            
            [
                'nom' => 'Secrétariat Général',
                'description' => 'Coordination générale des services municipaux',
                'responsable_id' => null,
                'email' => 'secretariat.general@gmail.com',
                'telephone' => '+221 33 987 65 40'
            ],

            [
                'nom' => 'Service Informatique',
                'description' => 'Gestion du parc informatique et systèmes d\'information',
                'responsable_id' => null,
                'email' => 'informatique.mairie@gmail.com',
                'telephone' => '+221 33 987 65 41'
            ],

            [
                'nom' => 'Service Communication',
                'description' => 'Relations publiques et communication municipale',
                'responsable_id' => null,
                'email' => 'communication.mairie@gmail.com',
                'telephone' => '+221 33 987 65 42'
            ],

            [
                'nom' => 'Agents Municipaux',
                'description' => 'Service des effectifs et ressources humaines',
                'responsable_id' => $agent ? $agent->id : null,
                'email' => 'rh.mairie@gmail.com',
                'telephone' => '+221 33 987 65 43'
            ],

            
            [
                'nom' => 'Service Finances',
                'description' => 'Gestion budgétaire et comptabilité',
                'responsable_id' => null,
                'email' => 'finances@gmail.com',
                'telephone' => '+221 33 888 77 66',
            ],
            [
                'nom' => 'Service Voirie',
                'description' => 'Entretien des routes et espaces publics',
                'responsable_id' => null,
                'email' => 'voirie@gmail.com',
                'telephone' => '+221 33 555 44 33',
            ]
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['email' => $service['email']],
                array_merge($service, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}