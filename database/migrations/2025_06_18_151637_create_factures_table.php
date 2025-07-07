<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrat_id')->constrained('contrats')->onDelete('cascade');
            $table->string('numero_facture')->unique();
            $table->date('date_facture');
            $table->date('date_echeance');
            $table->decimal('total_ht', 10, 2);
            $table->decimal('total_tva', 10, 2);
            $table->decimal('taxe_regionale', 10, 2)->default(0);
            $table->decimal('total_ttc', 10, 2);
            $table->decimal('montant_paye', 10, 2)->default(0);
            $table->string('statut')->default('non payée'); // e.g., non payée, payée, en retard
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};