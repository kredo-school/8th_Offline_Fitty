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
        Schema::create('daily_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('weight')->nullable();
            $table->string('meal_type')->nullable();
            $table->date('input_date')->nullable();
            $table->text('meal_content')->nullable();
            $table->text('comment')->nullable();
            $table->longText('image')->nullable();
            $table->text('nutritions')->nullable();
            $table->integer('meal_calorie')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_logs');
    }
};
