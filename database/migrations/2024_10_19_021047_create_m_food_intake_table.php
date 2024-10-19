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
        Schema::create('m_food_intake', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_user_id')->constrained('m_user');
            $table->string('food_name')->nullable();
            $table->string('description')->nullable();
            $table->enum('food_type', ['breakfast', 'lunch', 'dinner', 'snack'])->nullable();
            $table->string('portion')->nullable();
            $table->string('calories')->nullable();
            $table->string('protein')->nullable();
            $table->string('fat')->nullable();
            $table->string('carbohydrate')->nullable();
            $table->string('sugar')->nullable();
            $table->string('cholesterol')->nullable();
            $table->string('mass')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_food_intake');
    }
};
