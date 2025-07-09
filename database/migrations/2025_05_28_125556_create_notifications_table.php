<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('contrat_id')->nullable();
            $table->unsignedBigInteger('demande_id')->nullable();
            $table->unsignedBigInteger('source_user_id')->nullable();
            $table->string('titre');
            $table->text('commentaire')->nullable();
            $table->string('type')->nullable(); // Exemple : 'remplir_champs', 'changer_fichier', 'verifier_op'
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('cascade');
            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}