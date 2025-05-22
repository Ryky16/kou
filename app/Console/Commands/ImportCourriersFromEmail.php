<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use App\Models\Courrier;
use App\Models\User;
use App\Notifications\CourrierNotification;

class ImportCourriersFromEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courriers:import-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importer les courriers reçus par email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = Client::account('default');
        $client->connect();
        $folder = $client->getFolder('INBOX');
        foreach ($folder->messages()->unseen()->get() as $message) {
            // Créer le courrier dans la base
            $courrier = Courrier::create([
                'reference' => $message->getSubject(),
                'objet' => $message->getSubject(),
                'contenu' => $message->getTextBody(),
                'expediteur_email' => $message->getFrom()[0]->mail,
                'statut' => 'En attente',
                // Ajoute d'autres champs si besoin
            ]);
            // Notifier le secrétaire municipal
            $secretaire = User::whereHas('role', fn($q) => $q->where('name', 'Secretaire_Municipal'))->first();
            if ($secretaire) $secretaire->notify(new CourrierNotification($courrier));
            $message->setFlag('Seen');
        }
        $this->info('Import terminé.');
    }
}
