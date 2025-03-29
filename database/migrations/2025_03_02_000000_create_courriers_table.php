<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     */
    public function up(): void
    {
        Schema::create('courriers', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 50)->unique(); // Référence unique pour chaque courrier
            $table->foreignId('expediteur_id')->constrained('users')->onDelete('cascade'); // L’expéditeur est un utilisateur
            $table->foreignId('destinataire_id')->nullable()->constrained('users')->onDelete('set null'); // Destinataire (peut être null si en attente)
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null'); // Destinataire peut être un service
            $table->text('objet');
            $table->text('contenu');
            $table->enum('type', ['entrant', 'sortant'])->default('entrant'); // Courrier entrant ou sortant
            $table->enum('statut', ['en_attente', 'affecté', 'en_cours', 'traité', 'archivé'])->default('en_attente');
            $table->enum('priorite', ['basse', 'moyenne', 'élevée'])->default('moyenne');
            $table->dateTime('date_reception')->nullable();
            $table->dateTime('date_envoi')->nullable(); // Date d’envoi du courrier
            $table->string('piece_jointe')->nullable(); // Stockage du fichier en base de données
            $table->foreignId('affecte_a')->nullable()->constrained('users')->onDelete('set null'); // L'agent affecté au courrier
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Créateur du courrier (Secrétaire municipal)
            $table->timestamps();
        });
    }

    
    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('courriers');
    }
};
