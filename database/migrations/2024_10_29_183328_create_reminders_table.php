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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message')->nullable();
            $table->date('reminder_date')->nullable();
            $table->time('reminder_time')->nullable();
            $table->enum('type', ['breakfast', 'lunch', 'dinner', 'snack', 'drink', 'exercise', 'medicine', 'reading', 'other']);
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->foreignId('user_id')->constrained('m_user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
