<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('budget_entry_demande', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_id')->constrained()->onDelete('cascade');
            $table->foreignId('budget_entry_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

    }

    

    public function down(): void
    {
        Schema::dropIfExists('budget_entry_demande');
    }
};
