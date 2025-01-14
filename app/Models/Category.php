<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // 子カテゴリを取得するリレーション
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id'); // parent_id を使った自己結合
    }
}
