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
        Schema::create('advice', function (Blueprint $table) {
            $table->id();
            $table->integer('overall');
            $table->text('message');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('nutritionist_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_read')->default(0)->comment('0: 未読, 1: 既読');
            $table->boolean('is_liked')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advice');
    }
};
