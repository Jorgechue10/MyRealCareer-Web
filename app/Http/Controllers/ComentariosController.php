<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ComentarioRequest;
use Illuminate\Support\Facades\Auth;
use App\Comentario;
use App\Noticia;
use App\Tema;
use Illuminate\Database\Eloquent\Builder;

class ComentariosController extends Controller
{
    // Sólo pueden comentar los usuarios autenticados
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ComentarioRequest  $request
     * @param  string  $parent_id
     * @return \Illuminate\Http\Response
     */
    public function publicarComentario(ComentarioRequest $request, $parent_id = 0)
    {
        $parent_id = (int)$parent_id;
        $contenido = $request->input('contenido');
        $modelo = $request->session()->get('modelo');
        $modelo_id = $request->session()->get('modelo_id');
        
        if ($modelo === 'Tema') {
            $objeto = Tema::find($modelo_id);
        }else{
            $objeto = Noticia::find($modelo_id);
        }

        // Comprobamos que se trata de un nuevo comentario o si existe el comentario padre
        // sobre el que vamos a responder. Con esto se evita que modificando la url se inserten
        // datos donde no queramos
        if ($parent_id === 0 || $objeto->comentarios()->where(['id' => $parent_id, 'parent_id' => 0])->first()) {
            $comentario = new Comentario([
                'contenido' => $contenido,
                'user_id' => Auth::id(),
                'parent_id' => $parent_id
            ]);
            
            // Guardamos el comentario
            $objeto->comentarios()->save($comentario);
        }

        return view('comentarios.comentarios_seccion', compact('objeto'));
    }
}
