<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id(); 
            $table->string('titre');
            $table->string('type_economique');
            $table->unsignedBigInteger('contrat_id')->nullable();
            $table->json('champs')->nullable();
            $table->foreign('contrat_id')->references('id')->on('contrats')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};

