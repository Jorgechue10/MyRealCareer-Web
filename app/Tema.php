<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $fillable = ['asunto', 'contenido', 'user_id'];

    // Relación polimórfica con el modelo Foto
    public function foto()
    {
        return $this->morphOne("App\Foto", "fotable");
    }

    // Obtener el usuario al que pertenece el tema
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Relación M:M - Obtener las categorías a las que pertenece el tema
    public function categorias()
    {
        return $this->belongsToMany('App\Categoria');
    }

    //Relación polimórfica con el modelo Comentario
    public function comentarios()
    {
        return $this->morphMany("App\Comentario", "comentable")->where("parent_id", 0);
    }

    //Relación polimórfica con el modelo Like
    public function likes()
    {
        return $this->morphMany("App\Like", "likeable");
    }
}
