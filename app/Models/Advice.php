<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function nutritionist()
    {
        return $this->belongsTo(Nutritionist::class);
    }

}
