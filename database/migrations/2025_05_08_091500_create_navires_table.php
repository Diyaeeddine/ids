<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNaviresTable extends Migration
{
    public function up()
    {
        Schema::create('navires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('type')->nullable();
            $table->string('port')->nullable();
            $table->string('numero_immatriculation')->nullable();
            $table->string('pavillon')->nullable();
            $table->decimal('longueur', 6, 2)->nullable();
            $table->decimal('largeur', 6, 2)->nullable();
            $table->decimal('tirant_eau', 6, 2)->nullable();
            $table->decimal('tirant_air', 6, 2)->nullable();
            $table->decimal('jauge_brute', 10, 2)->nullable();
            $table->year('annee_construction')->nullable();
            $table->string('marque_moteur')->nullable();
            $table->string('type_moteur')->nullable();
            $table->string('numero_serie_moteur')->nullable();
            $table->string('puissance_moteur')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('navires');
    }
}
?>