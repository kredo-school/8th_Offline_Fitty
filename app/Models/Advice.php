<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Advice extends Model
{
    protected $table = 'advice'; 
    protected $fillable = ['overall', 'message', 'user_id', 'nutritionist_id', 'is_read', 'is_liked'];

    protected $casts = [
        'is_read' => 'boolean',
        'is_liked' => 'boolean',
    ];

    // 受け取ったユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Nutritionist からのアドバイス
    public function nutritionist()
    {
        return $this->belongsTo(User::class, 'nutritionist_id');
    }
}
