<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('affectations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change(); // rendre user_id nullable
        });
    }

    public function down(): void
    {
        Schema::table('affectations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change(); // revenir à NOT NULL si rollback
        });
    }
};
