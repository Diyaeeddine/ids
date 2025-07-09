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
        Schema::create('order_v', function (Blueprint $table) {
            $table->id(); 
            $table->integer('id_op'); 
            $table->date('date_virement')->nullable(); 
            $table->string('compte_debiteur')->nullable(); 
            $table->decimal('montant', 15, 2);
            $table->string('beneficiaire_nom'); 
            $table->string('beneficiaire_rib'); 
            $table->string('beneficiaire_banque');
            $table->string('beneficiaire_agence'); 
            $table->text('objet')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_v');
    }
};