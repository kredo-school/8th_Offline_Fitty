<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{

     // マスアサインメント可能な属性を指定
     protected $fillable = [
        'user_id3',
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'height',
        'exercise_frequency',
        'activity_level',
        'health_conditions',
        'dietary_preferences',
        'food_allergies',
        'goals',
        'user_id', // リレーション用
    ];

    // リレーション: Userモデルに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
