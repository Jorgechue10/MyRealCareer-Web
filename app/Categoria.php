<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{   
    // Relación N:M - Obtener los temas a partir de la categoría
    public function temas()
    {
        return $this->belongsToMany('App\Tema');
    }
}
