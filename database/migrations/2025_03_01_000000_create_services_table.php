<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute la migration.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100)->unique(); // Nom unique pour éviter les doublons
            $table->text('description')->nullable(); // Description facultative
            $table->foreignId('responsable_id')->nullable()->constrained('users')->onDelete('set null'); 
            $table->string('email', 100)->unique()->nullable(); // Email du service
            $table->string('telephone', 20)->nullable(); // Numéro de téléphone
            $table->timestamps(); // Ajoute automatiquement created_at et updated_at
        });
    }

    /**
     * Annule la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
