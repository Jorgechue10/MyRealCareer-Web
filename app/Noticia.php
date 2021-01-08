<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    // Usamos SoftDeletes para mantener las noticias eliminadas
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['titulo', 'contenido'];

    //Obtener el tiempo transcurrido desde la publicación de la noticia a la actualidad
    public function getTiempoAttribute()
    {
        return \Helper::formatoTiempo($this->created_at);
    }

    //Relación polimórfica con el modelo Foto
    public function foto()
    {
        return $this->morphOne("App\Foto", "fotable");
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
