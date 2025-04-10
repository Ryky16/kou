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
        Schema::create('pieces_jointes', function (Blueprint $table) {
            $table->id();
            $table->string('chemin');
            $table->string('nom_original');
            $table->string('mime_type');
            $table->unsignedInteger('taille');
            $table->foreignId('courrier_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->index('courrier_id'); // Index pour les performances
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pieces_jointes');
    }
};
