<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'name',
        'requirement',
        'category_id', 
        // 他に許可したいフィールドがあればここに追加
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
