<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\User;
use App\Foto;
use App\Like;

class UsersController extends Controller
{
    // Carpeta donde se almacenan las fotos de los usuarios
    private $carpeta_fotos = 'images/users/';

    // Sólo pueden interactuar los usuarios autenticados 
    // Los usuarios con rol de administrador serán los únicos que puedan crear usuarios
    public function __construct() {
        $this->middleware('EsAdmin')->only(['create', 'store']);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(15);
        $section__name = "Usuarios";
        $pagination = true;

        return view('cuenta.user_index', compact('users', 'section__name', 'pagination'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entrada = $request->all();
        $user = User::create($entrada);
        
        if ($archivo = $request->file('foto')) {            
           
            $ruta_foto =  \Helper::almacenarFoto($user, $archivo, $this->carpeta_fotos);

            $foto = new Foto([
                'ruta_foto' => $ruta_foto
            ]);

            $user->foto()->save($foto);            
        }

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('cuenta.perfil', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Sólo pueden editar los usuarios los administradores y los propios usuarios
        if (\Auth::user()->esAdmin() || \Auth::user()->id === (int)$id) {
            $user = User::findOrFail($id);

            return view('cuenta.user_edit', compact('user'));
        }else{
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validación de los datos
        request()->validate([
            'name' => 'required|max:50',
            'email' => [
                'required',
                'max:50',
                'email',
                \Illuminate\Validation\Rule::unique('users')->ignore($user->id),
            ],
            'foto_nueva' => 'mimes:jpeg,jpg,png,gif,bmp,tiff|max:2048'
        ],
        [
            'required' => 'El campo :attribute es obligatorio.',
            'max' => 'El campo :attribute no puede tener más de :max dígitos.',
            'email.email' => 'El campo :attribute tiene un formato inválido.',
            'email.unique' => 'Ya existe un usuario con ese email.',
            'mimes' => 'Sólo están permitidos los formatos: jpeg, png, gif, bmp, tiff.',
        ]);

        $entrada = $request->all();

        // Actualizamos o creamos la foto
        if ($archivo = $request->file('foto_nueva')) {            
        
            $ruta_foto = \Helper::almacenarFoto($user, $archivo, $this->carpeta_fotos);
            
            if (!$user->foto) {
                $foto = new Foto([
                    'ruta_foto' => $ruta_foto
                ]);
    
            }else{
                $foto = $user->foto;
                $foto->ruta_foto = $ruta_foto;
            }
            $user->foto()->save($foto);
        }
        $user->update($entrada);

        return redirect("/users/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->id === (int)$id) {
            \Auth::logout();
        }

        $user = User::findOrFail($id);
        
        if ($foto = $user->foto){
            \File::delete($foto->ruta_foto);
            $user->foto()->delete();
        }
        //$user->delete();
        $user->forceDelete();

        $user->likes()->delete();
        $user->seguidores()->delete();

        Session::flash('user_borrado', 'El usuario ha sido eliminado con éxito');
        
        return redirect()->back();
    }

    /**
     * Mostrar los usuarios que están sido seguidos por un usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function showSiguiendo($id)
    {
        $user = User::findOrFail($id);
        $siguiendo = $user->siguiendo;
        foreach ($siguiendo as $value) {
            $users[] = $value->likeable;
        }
        $section__name = $user->name . ' - Siguiendo';

        // Paginación
        $page = Paginator::resolveCurrentPage() ?? 1;
        $perPage = 15;
        $offset = ($page * $perPage) - $perPage;

        $array = array_slice($users, $offset, $perPage, true);
        $users = new LengthAwarePaginator($array, count($users), $perPage, $page, ['path'=>url("users/$id/siguiendo")]);
       
        return view('cuenta.user_index', compact('users', 'section__name'));
    }

    /**
     * Mostrar los seguidores de un usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function showSeguidores($id)
    {
        $user = User::findOrFail($id);
        $seguidores = $user->seguidores;
        foreach ($seguidores as $seguidor) {
            $users[] = $seguidor->user;
        }
        $section__name = $user->name . ' - Seguidores';

        // Paginación
        $page = Paginator::resolveCurrentPage() ?? 1;
        $perPage = 15;
        $offset = ($page * $perPage) - $perPage;

        $array = array_slice($users, $offset, $perPage, true);
        $users = new LengthAwarePaginator($array, count($users), $perPage, $page, ['path'=>url("users/$id/seguidores")]);
       
        return view('cuenta.user_index', compact('users', 'section__name'));
    }

    /**
     * Mostrar las noticias favoritas de un usuario (relacionadas con el modelo Like)
     *
     * @return \Illuminate\Http\Response
     */
    public function showNoticiasFavoritos($id)
    {
        $user = User::findOrFail($id);
        $noticias_like = $user->likes->where('likeable_type', 'App\Noticia') ?? [];
        $noticias = [];
        foreach ($noticias_like as $like) {
            $noticias[] = $like->likeable;
        }
        $section__name = $user->name . ' - Noticias fovoritas';

        // Paginación
        $page = Paginator::resolveCurrentPage() ?? 1;
        $perPage = 15;
        $offset = ($page * $perPage) - $perPage;

        $array = array_slice($noticias, $offset, $perPage, true);
        $noticias = new LengthAwarePaginator($array, count($noticias), $perPage, $page, ['path'=>url("users/$id/noticias/favoritos")]);
       
        return view('cuenta.user_noticias', compact('noticias', 'section__name'));
    }

    /**
     * Mostrar los temas favoritos de un usuario (relacionados con el modelo Like)
     *
     * @return \Illuminate\Http\Response
     */
    public function showTemasFavoritos($id)
    {
        $user = User::findOrFail($id);
        $temas_like = $user->likes->where('likeable_type', 'App\Tema');
        $temas = [];
        foreach ($temas_like as $like) {
            $temas[] = $like->likeable;
        }
        $section__name = $user->name . ' - Temas fovoritos';

        // Paginación
        $page = Paginator::resolveCurrentPage() ?? 1;
        $perPage = 15;
        $offset = ($page * $perPage) - $perPage;

        $array = array_slice($temas, $offset, $perPage, true);
        $temas = new LengthAwarePaginator($array, count($temas), $perPage, $page, ['path'=>url("users/$id/temas/favoritos")]);
       
        return view('cuenta.user_temas', compact('temas', 'section__name'));
    }

    /**
     * Mostrar los temas publicados por un usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function showTemasPublicados($id)
    {
        $user = User::findOrFail($id);
        $temas = $user->temas->all();

        $section__name = $user->name . ' - Temas publicados';

        // Paginación
        $page = Paginator::resolveCurrentPage() ?? 1;
        $perPage = 15;
        $offset = ($page * $perPage) - $perPage;

        $array = array_slice($temas, $offset, $perPage, true);
        $temas = new LengthAwarePaginator($array, count($temas), $perPage, $page, ['path'=>url("users/$id/temas/favoritos")]);
       
        return view('cuenta.user_temas', compact('temas', 'section__name'));
    }
}
