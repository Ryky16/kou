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
            $table->string('reference')->unique();
            $table->string('expediteur');
            $table->string('destinataire');
            $table->text('objet');
            $table->text('contenu');
            $table->enum('type', ['entrant', 'sortant']);
            $table->enum('statut', ['en_attente', 'traité', 'archivé'])->default('en_attente');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Affectation à un utilisateur
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
