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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id(); // プライマリーキー
            $table->unsignedBigInteger('user_id'); // ユーザーID（必須）
            $table->string('name'); // 名前
            $table->string('email'); // メールアドレス
            $table->string('title'); // お問い合わせのタイトル
            $table->text('content'); // お問い合わせ内容
            $table->string('category')->nullable(); // お問い合わせのカテゴリ
            $table->text('memo')->nullable(); // 運営側のメモ（対応履歴など）
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending'); // ステータス
            $table->string('person_in_charge')->nullable(); // 担当者
            $table->timestamps(); // created_at & updated_at（デフォルトで追加される）
            
            // 外部キー制約（ユーザーが削除されたときに問い合わせも削除される場合）
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
