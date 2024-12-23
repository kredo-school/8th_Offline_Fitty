<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nutritionist extends Model
{
    public function users(){
    return $this->hasMany(User::class);
    }

    public function advice()
    {
        return $this->hasMany(Advice::class);
    }

}
