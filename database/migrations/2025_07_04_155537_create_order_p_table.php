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
    Schema::create('order_p', function (Blueprint $table) {
        $table->id();
        $table->string('entite_ordonnatrice')->nullable();
        $table->string('marche_bc')->nullable();
        $table->unsignedBigInteger('id_facture')->nullable();
        $table->string('fournisseur')->nullable();
        $table->string('periode_facturation')->nullable();
        $table->date('date_paiment')->nullable();
        $table->text('description_operation')->nullable();
        $table->string('pieces_justificatives')->nullable();
        $table->decimal('montant_chiffres', 15, 2)->nullable();
        $table->string('montant_lettres')->nullable();
        $table->date('date_mise_paiement')->nullable();
        $table->string('mode_paiement')->nullable();
        $table->string('reference')->nullable();
        $table->text('observations')->nullable();
        $table->string('visa_controle')->nullable();
        $table->string('imputation_comptable')->nullable();
        $table->string('metier')->nullable();
        $table->string('section_analytique')->nullable();
        $table->string('produit')->nullable();
        $table->string('extension_analytique')->nullable();
        $table->boolean('is_accepted')->default(false);
        $table->timestamps();
    });
}

};
