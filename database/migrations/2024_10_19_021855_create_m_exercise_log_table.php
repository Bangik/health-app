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
            $table->foreignId('m_user_id')->constrained('m_user')->onDelete('cascade');
            $table->foreignId('m_exercise_id')->constrained('m_exercise')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('calories')->nullable();
            $table->integer('distance')->nullable();
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
