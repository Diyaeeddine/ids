<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratsSignesTable extends Migration
{
    public function up()
    {
        Schema::create('contrats_signes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('contrat_id');
            $table->string('fichier_path'); 
            $table->timestamp('imported_at')->nullable();

            $table->timestamps();

            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contrats_signes');
    }
}