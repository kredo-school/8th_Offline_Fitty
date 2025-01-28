<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionistsProfile extends Model
{
    // リレーション: Userモデルに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
