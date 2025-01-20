<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // 子カテゴリを取得するリレーション
    public function subcategory()
    {
        return $this->hasMany(SubCategory::class);
    }
}
