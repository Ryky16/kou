<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Étape 1 : changer les valeurs
        DB::statement("UPDATE courriers SET priorite = 'normal' WHERE priorite = 'basse'");
        DB::statement("UPDATE courriers SET priorite = 'important' WHERE priorite = 'moyenne'");
        DB::statement("UPDATE courriers SET priorite = 'urgent' WHERE priorite = 'haute'");

        // Étape 2 : changer le type ENUM
        DB::statement("ALTER TABLE courriers MODIFY priorite ENUM('normal', 'important', 'urgent') DEFAULT 'normal'");
        DB::statement("ALTER TABLE courriers MODIFY statut ENUM('brouillon', 'envoyé', 'archivé') DEFAULT 'brouillon'");
    }

    public function down(): void
    {
        // ✅ ÉTAPE 1 : on rend la colonne temporairement permissive
        DB::statement("ALTER TABLE courriers MODIFY priorite VARCHAR(20)");

        // ✅ ÉTAPE 2 : remettre les anciennes valeurs
        DB::statement("UPDATE courriers SET priorite = 'basse' WHERE priorite = 'normal'");
        DB::statement("UPDATE courriers SET priorite = 'moyenne' WHERE priorite = 'important'");
        DB::statement("UPDATE courriers SET priorite = 'haute' WHERE priorite = 'urgent'");

        // ✅ ÉTAPE 3 : remettre l’ENUM d’origine
        DB::statement("ALTER TABLE courriers MODIFY priorite ENUM('basse', 'moyenne', 'haute') DEFAULT 'moyenne'");
        DB::statement("ALTER TABLE courriers MODIFY statut ENUM('brouillon', 'envoyé', 'traité') DEFAULT 'brouillon'");
    }
};
