<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory;

    // 一括代入を許可する属性
    protected $fillable = [
        'category',
        'name',
        'submission_date',
        'status',
    ];

    // submission_dateをCarbonインスタンスとして扱う
    protected $casts = [
        'submission_date' => 'datetime',
    ];
}