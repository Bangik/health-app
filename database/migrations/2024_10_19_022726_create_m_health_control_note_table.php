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
        Schema::create('m_health_control_note', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_user_id')->constrained('m_user')->onDelete('cascade');
            $table->integer('systolic_pressure')->nullable();
            $table->integer('diastolic_pressure')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_health_control_note');
    }
};
