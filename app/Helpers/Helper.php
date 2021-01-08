<?php

namespace App\Helpers;

class Helper
{
    //Obtener el tiempo transcurrido desde la publicación de la noticia a la actualidad
    public static function formatoTiempo($tiempo)
    {
        $fecha1 = new \DateTime($tiempo->toDateTimeString());
        $fecha2 = new \DateTime("now");
        $diferencia = $fecha1->diff($fecha2);
        if($diferencia->y > 0){
            $rtdo = $diferencia->y . " años";
        }else if($diferencia->m > 0){
            $rtdo = $diferencia->m . " meses";
        }elseif ($diferencia->d > 0) {
            $rtdo = $diferencia->d . " días";
        }elseif ($diferencia->h > 0) {
            $rtdo = $diferencia->h . " horas";
        }elseif ($diferencia->i > 0) {
            $rtdo = $diferencia->i . " minutos";
        } else {
            $rtdo = $diferencia->s . " segundos";
        }
        return $rtdo;
    }

    // Almacenar una foto en la ruta /public/images/...
    public static function almacenarFoto($objeto, $archivo, $carpeta_fotos)
    {
        // Nombre foto
        $extension = pathinfo($archivo->getClientOriginalName())['extension'];
        $objeto_id = str_pad($objeto->id, 6, '0', STR_PAD_LEFT);
        $object_name = strtolower(class_basename($objeto));
        $nombre = $object_name . '_id_' . $objeto_id . '.' . $extension;

        //Eliminar foto si existe
        if($objeto->foto && is_file($objeto->foto->ruta_foto)) {
            \File::delete($objeto->foto->ruta_foto);
        }

        // Almacenar foto
        $archivo->move($carpeta_fotos, $nombre);

        return $carpeta_fotos . $nombre;
    }
}