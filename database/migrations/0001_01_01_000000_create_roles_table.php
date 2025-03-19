<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Importez DB pour insérer des données

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nom du rôle (ex: Administrateur, Secrétaire municipal, Agent)
            $table->timestamps();
        });

        // Insérez les rôles par défaut
        DB::table('roles')->insert([
            ['name' => 'Administrateur'],
            ['name' => 'Secretaire_Municipal'],
            ['name' => 'Agent'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};