<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffectationsTable extends Migration
{
    public function up()
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courrier_id');
            $table->unsignedBigInteger('user_id'); // destinataire
            $table->string('statut')->default('non_lu');
            $table->timestamps();

            $table->foreign('courrier_id')->references('id')->on('courriers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('affectations');
    }
}
