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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // サブカテゴリ名
            $table->decimal('requirement', 10, 5)->default(0.0); // 小数点対応のdecimal型に変更
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete(); // categoriesテーブルへの外部キー
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
