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
        Schema::table('recipes', function (Blueprint $table) {
            $table->float('calories')->change()->nullable();
            $table->float('protein')->change()->nullable();
            $table->float('fat')->change()->nullable();
            $table->float('carbohydrate')->change()->nullable();
            $table->float('sugar')->change()->nullable();
            $table->float('potassium')->change()->nullable();
            $table->float('mass')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->integer('calories')->change();
            $table->integer('protein')->change();
            $table->integer('fat')->change();
            $table->integer('carbohydrate')->change();
            $table->integer('sugar')->change();
            $table->integer('potassium')->change();
            $table->integer('mass')->change();
        });
    }
};
