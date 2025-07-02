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
            Schema::create('budget_entries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('budget_table_id')->constrained()->onDelete('cascade');
        $table->string('imputation_comptable')->nullable();
        $table->string('intitule')->nullable();
        $table->boolean('is_header')->default(false);
        $table->decimal('budget_previsionnel', 15, 2)->nullable();
        $table->decimal('atterrissage', 15, 2)->nullable();
        $table->string('b_title')->nullable();
        $table->integer('position')->nullable(); 
        
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_entries');
    }
};
