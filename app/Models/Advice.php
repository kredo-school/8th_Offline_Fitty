<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; 


class Advice extends Model
{
    protected $table = 'advice'; 
    protected $fillable = ['overall', 'message', 'user_id', 'nutritionist_id', 'is_read', 'is_liked'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}



    


