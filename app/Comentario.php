<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    // Usamos SoftDeletes para mantener las noticias eliminadas
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contenido', 'user_id', 'parent_id', 'comentable_id', 'comentable_type'];

    // Obtener el usuario al que pertenece el comentario
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //Relación polimórfica con los modelos: Noticia, Tema, Comentario
    public function comentable()
    {
        return $this->morphTo();
    }

    //Relación 1:N - Un comentario puede tener varias respuestas
    public function respuestas()
    {
        return $this->hasMany("App\Comentario", "parent_id");
    }

    //Relación polimórfica con el modelo Like
    public function likes()
    {
        return $this->morphMany("App\Like", "likeable");
    }
}
