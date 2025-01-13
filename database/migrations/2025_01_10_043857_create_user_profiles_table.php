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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // usersテーブルとのリレーション
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('height')->nullable();
            $table->integer('activity_level')->nullable();
            $table->longtext('avatar')->nullable();
            $table->longtext('profile_image')->nullable();
            $table->text('memo')->nullable();
            $table->text('nutritionist_memo')->nullable();
            $table->date('advice_sent_date')->nullable(); // アドバイス送信日
            $table->unsignedBigInteger('nutritionist_id')->nullable();
            $table->json('health_conditions')->nullable();
            $table->json('dietary_preferences')->nullable();
            $table->text('food_allergies')->nullable();
            $table->text('goals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
