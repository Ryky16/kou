<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courrier_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Celui qui affecte
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade'); // Celui qui reçoit
            $table->string('action')->default('affectation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courrier_logs');
    }
};
