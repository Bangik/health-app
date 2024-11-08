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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('food_name')->nullable();
            $table->string('description')->nullable();
            $table->enum('food_type', ['breakfast', 'lunch', 'dinner', 'snack'])->nullable();
            $table->string('portion')->nullable();
            $table->integer('calories')->nullable();
            $table->integer('protein')->nullable();
            $table->integer('fat')->nullable();
            $table->integer('carbohydrate')->nullable();
            $table->integer('sugar')->nullable();
            $table->integer('cholesterol')->nullable();
            $table->integer('mass')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe');
    }
};
