<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionistAssign extends Model
{
    use HasFactory;

    protected $table = 'nutritionist_assign_tbl'; // テーブル名を指定

    protected $fillable = [
        'last_assigned_nutritionist_id',
    ];
}
