<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('courriers')) {
            return;
        }
        
        Schema::create('courriers', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 50)->unique();
            
            // Relations avec noms ORIGINAUX
            $table->foreignId('expediteur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('destinataire_id')->nullable()->constrained('users')->nullOnDelete();//onDelete('set null');
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete(); //onDelete('set null');
            
            // Contenu
            $table->text('objet');
            $table->text('contenu');
            
            // Workflow
            $table->enum('type', ['entrant', 'sortant', 'interne'])->default('interne');
            $table->enum('statut', ['brouillon', 'envoyé', 'traité'])->default('brouillon');
            $table->enum('priorite', ['basse', 'moyenne', 'haute'])->default('moyenne');
            
            // Dates
            $table->timestamp('date_reception')->nullable();
            
            // Traçabilité
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courriers');
    }
};