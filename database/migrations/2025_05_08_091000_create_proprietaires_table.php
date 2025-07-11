<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProprietairesTable extends Migration
{
    public function up()
    {
        Schema::create('proprietaires', function (Blueprint $table) {
            $table->id();
            $table->string('type'); 
            $table->string('nom');
            $table->string('tel')->nullable();
            $table->string('nom_societe')->nullable();
            $table->string('ice')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('cin_pass_phy')->nullable();
            $table->string('cin_pass_mor')->nullable();
            $table->date('validite_cin')->nullable();
            $table->string('caution_solidaire')->nullable();
            $table->string('passeport')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proprietaires');
    }
}

?>