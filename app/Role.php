<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //Relación 1:N - Un rol pertenece a muchos usuarios
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
