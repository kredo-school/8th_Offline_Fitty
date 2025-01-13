
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // public function up(): void
    // {
    //     Schema::create('users', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name'); 
    //         $table->string('email')->unique();
    //         $table->string('password');
    //         $table->enum('gender', ['male', 'female', 'non_binary', 'other', 'prefer_not_to_say']);
    //         $table->date('birthday');
    //         $table->integer('height');
    //         $table->string('avatar')->default('default_avatar.png');
    //         $table->integer('activity_level')->default(0);
    //         $table->text('nutritionist_memo')->nullable()->comment('Optional memo from the nutritionist');
    //         $table->string('role')->default('user');
    //         $table->foreignId('nutritionist_id')->nullable()->constrained('nutritionists')->nullOnDelete();
    //         $table->json('health_conditions'); 
    //         $table->json('dietary_preferences'); 
    //         $table->text('food_allergies')->nullable(); 
    //         $table->text('goals')->nullable(); 
    //         $table->timestamps();
    //     });

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('gender', ['male', 'female', 'non_binary', 'other', 'prefer_not_to_say']);
            $table->date('birthday')->default('2011-01-01');
            $table->integer('height')->default(0);
            $table->enum('exercise_frequency', ['Level_1', 'Level_2', 'Level_3'])->nullable();
            $table->string('profile_image')->default('default_profile_image.png');
            // $table->text('nutritionist_memo')->nullable();
            $table->string('role')->default('user');
            $table->foreignId('nutritionist_id')->nullable()->constrained('nutritionists')->nullOnDelete();
            $table->json('health_conditions')->default(json_encode([])); // JSONカラムにデフォルト値を設定
            $table->json('dietary_preferences')->default(json_encode([])); // デフォルト値を設定
            $table->text('food_allergies')->nullable();
            $table->text('goals')->nullable();
            $table->timestamps();
        });
    
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Drop users table
        Schema::dropIfExists('password_reset_tokens'); // Drop password reset tokens table
        Schema::dropIfExists('sessions'); // Drop sessions table
    }
};
