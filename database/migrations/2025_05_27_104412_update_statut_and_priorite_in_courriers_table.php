<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         // Si tu avais d’anciennes valeurs genre 'basse', 'moyenne', 'haute'
    // Tu dois d’abord t'assurer qu’elles sont transformées en les nouvelles AVANT de modifier l’ENUM

    DB::statement("UPDATE courriers SET priorite = 'normal' WHERE priorite = 'basse'");
    DB::statement("UPDATE courriers SET priorite = 'important' WHERE priorite = 'moyenne'");
    DB::statement("UPDATE courriers SET priorite = 'urgent' WHERE priorite = 'haute'");

    // Ensuite seulement tu modifies le champ ENUM
    DB::statement("ALTER TABLE courriers MODIFY priorite ENUM('normal', 'important', 'urgent') DEFAULT 'normal'");
    DB::statement("ALTER TABLE courriers MODIFY statut ENUM('brouillon', 'envoyé', 'archivé') DEFAULT 'brouillon'");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       // Reviens à l’ancienne définition ENUM
    DB::statement("ALTER TABLE courriers MODIFY priorite ENUM('basse', 'moyenne', 'haute') DEFAULT 'moyenne'");
    DB::statement("ALTER TABLE courriers MODIFY statut ENUM('brouillon', 'envoyé', 'traité') DEFAULT 'brouillon'");

    // Puis remets les anciennes valeurs
    DB::statement("UPDATE courriers SET priorite = 'basse' WHERE priorite = 'normal'");
    DB::statement("UPDATE courriers SET priorite = 'moyenne' WHERE priorite = 'important'");
    DB::statement("UPDATE courriers SET priorite = 'haute' WHERE priorite = 'urgent'");
    }
};
