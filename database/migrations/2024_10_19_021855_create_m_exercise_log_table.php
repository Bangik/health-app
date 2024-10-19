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
        Schema::create('m_exercise_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_user_id')->constrained('m_user');
            $table->foreignId('m_exercise_id')->constrained('m_exercise');
            $table->string('description')->nullable();
            $table->string('duration')->nullable();
            $table->string('calories')->nullable();
            $table->string('distance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_exercise_log');
    }
};
