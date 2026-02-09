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
        Schema::create('qc_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('call_id')->constrained()->cascadeOnDelete();
            $table->foreignId('qc_agent_id')->constrained('users')->cascadeOnDelete();
            
            // Scoring Categories (1-5 or 1-10, let's assume 1-5 for now, or 0-100)
            // Let's use 1-5 integers
            $table->unsignedTinyInteger('communication_score')->nullable();
            $table->unsignedTinyInteger('confidence_score')->nullable();
            $table->unsignedTinyInteger('professionalism_score')->nullable();
            $table->unsignedTinyInteger('closing_score')->nullable();
            
            $table->text('remarks')->nullable();
            $table->boolean('is_locked')->default(false); // Admin can lock scores
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qc_scores');
    }
};
