<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ruta_foto', 'fotable_id', 'fotable_type'];

    //Relación polimórfica con los modelos: User, Tema, Noticia
    public function fotable()
    {
        return $this->morphTo();
    }
}
