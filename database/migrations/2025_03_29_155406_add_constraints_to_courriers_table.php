<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter cette contrainte SEULEMENT après la création de la table
        DB::statement("
           ALTER TABLE courriers 
        ADD CONSTRAINT chk_destinataire 
        CHECK (
            (type = 'entrant' AND expediteur_id IS NOT NULL) OR
            (type = 'sortant' AND (destinataire_id IS NOT NULL OR service_id IS NOT NULL OR email_destinataire IS NOT NULL)) OR
            (type = 'interne' AND (destinataire_id IS NOT NULL OR service_id IS NOT NULL))
        )
        ");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE courriers DROP CONSTRAINT chk_destinataire");
    }
};