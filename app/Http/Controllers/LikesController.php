<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;

class LikesController extends Controller
{
    // Sólo pueden dar a 'like' los usuarios autenticados
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Crear/Eliminar un LIke.
     * Si el Like existe, lo borra y si no existe, lo crea
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function click(Request $request)
    {
        $likeable_id = $request->input('id');
        $likeable_type = $request->input('type');
        $usuario = Auth::user();
        $user_id = $usuario->id;

        // 1->User, 2->Noticia, 3->Tema, 4->Comentario
        switch ($likeable_type) {
            case '1':
                $likeable_type = "App\User";
                break;
            case '2':
                $likeable_type = "App\Noticia";
                break;
            case '3':
                $likeable_type = "App\Tema";
                break;
            case '4':
                $likeable_type = "App\Comentario";
                break;
            default:
                return redirect()->back();
                break;
        }

        $atributos = ['user_id' => $user_id, "likeable_id" => $likeable_id, "likeable_type" => $likeable_type];
        if ($like = Like::where($atributos)->first()) {
            // Borramos el Like
            $like->delete();
            $status = false;
        }else {
            // Guardamos el Like
            $like = new Like($atributos);
            $usuario->likes()->save($like);
            $status = true;
        }

        $numeroLikes = Like::where(["likeable_id" => $likeable_id, "likeable_type" => $likeable_type])->count();
        if ($request->ajax()) {
            return response()->json([
                "numeroLikes" => $numeroLikes,
                "status" => $status
            ]);
        }
        return redirect()->back();
    }
}
