<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];

    // Relación con User (user_id)
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //Relación polimórfica con los modelos: Noticia, Tema, Comentario, User
    public function likeable()
    {
        return $this->morphTo();
    }
}
