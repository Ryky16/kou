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
        // 1. Mettre à jour les anciennes valeurs AVANT de modifier l'ENUM
        DB::statement("UPDATE courriers SET priorite = 'normal' WHERE priorite = 'basse'");
        DB::statement("UPDATE courriers SET priorite = 'important' WHERE priorite = 'moyenne'");
        DB::statement("UPDATE courriers SET priorite = 'urgent' WHERE priorite = 'haute'");

        // 2. Modifier les ENUM ensuite
        DB::statement("ALTER TABLE courriers MODIFY statut ENUM('brouillon', 'envoyé', 'archivé') DEFAULT 'brouillon'");
        DB::statement("ALTER TABLE courriers MODIFY priorite ENUM('normal', 'important', 'urgent') DEFAULT 'normal'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Remettre les anciennes valeurs AVANT de modifier l'ENUM
        DB::statement("UPDATE courriers SET priorite = 'basse' WHERE priorite = 'normal'");
        DB::statement("UPDATE courriers SET priorite = 'moyenne' WHERE priorite = 'important'");
        DB::statement("UPDATE courriers SET priorite = 'haute' WHERE priorite = 'urgent'");

        // 2. Remettre l'ancien ENUM ensuite
        DB::statement("ALTER TABLE courriers MODIFY statut ENUM('brouillon', 'envoyé', 'traité') DEFAULT 'brouillon'");
        DB::statement("ALTER TABLE courriers MODIFY priorite ENUM('basse', 'moyenne', 'haute') DEFAULT 'moyenne'");
    }
};
