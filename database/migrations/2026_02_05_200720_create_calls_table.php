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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dispatcher_id')->constrained()->cascadeOnDelete();
            $table->string('openphone_call_id')->unique(); // Unique ID from OpenPhone
            $table->string('from_number');
            $table->string('to_number');
            $table->string('direction'); // inbound/outbound
            $table->text('recording_url')->nullable();
            $table->integer('duration')->default(0); // in seconds
            $table->timestamp('called_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
