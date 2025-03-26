<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courriers', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 50)->unique(); // Limite à 50 caractères pour éviter du stockage inutile
            $table->string('expediteur', 100);
            $table->string('destinataire', 100);
            $table->text('objet');
            $table->text('contenu');
            $table->enum('type', ['entrant', 'sortant']);
            $table->enum('statut', ['en_attente', 'affecté', 'en_cours', 'traité', 'archivé'])->default('en_attente'); // Ajout de "affecté" et "en_cours"
            $table->enum('priorite', ['basse', 'moyenne', 'élevée'])->default('moyenne'); // Ajout d'une priorité
            $table->dateTime('date_reception')->nullable(); // Permet de suivre la réception
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relation avec les utilisateurs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courriers');
    }
};
