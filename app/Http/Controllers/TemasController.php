<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TemaRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Tema;
use App\Foto;
use App\Categoria;

class TemasController extends Controller
{
    // Carpeta donde se almacenan las fotos de los temas
    private $carpeta_fotos = 'images/temas/';

    // Los usuarios que no estén atenticados sólo podrán leer los temas
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temas = Tema::orderBy('created_at', 'DESC')->paginate(10);
        return view('temas.index', compact('temas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = Categoria::all();

        return view('temas.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TemaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemaRequest $request)
    {
        $entrada = $request->all();
        $entrada['user_id'] = \Auth::user()->id;

        $tema = Tema::create($entrada);
        
        // Guardamos las categorías del tema
        $input_categorias = $request->input('categorias') ?? [];
        foreach ($input_categorias as $categoria_id) {
            $categoria = Categoria::findOrFail($categoria_id);
            $tema->categorias()->save($categoria);
        }
        
        // Almacenamos la foto
        if ($archivo = $request->file('foto')) {            
           
            $ruta_foto =  \Helper::almacenarFoto($tema, $archivo, $this->carpeta_fotos);

            $foto = new Foto([
                'ruta_foto' => $ruta_foto
            ]);

            $tema->foto()->save($foto);            
        }

        return redirect('/temas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tema = Tema::findOrFail($id);

        return view('temas.show', compact('tema'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $categoria_id
     * @return \Illuminate\Http\Response
     */
    public function showTemasCategoria($categoria_id)
    {
        $categoria = Categoria::findOrFail($categoria_id);
        $temas_categoria = $categoria->temas->sortByDesc('created_at')->all();
        $nombre_categoria = $categoria->nombre;
        
        $page = Paginator::resolveCurrentPage() ?? 1;
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        $array = array_slice($temas_categoria, $offset, $perPage, true);
        $temas = new LengthAwarePaginator($array, count($temas_categoria), $perPage, $page, ['path'=>url("temas/categoria/$categoria_id")]);
       
        return view('temas.index', compact('temas', 'nombre_categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tema = Tema::findOrFail($id);
        $categorias = Categoria::all();

        return view('temas.edit', compact('tema', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\TemaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TemaRequest $request, $id)
    {
        $tema = Tema::findOrFail($id);
        $entrada = $request->all();  
        
        // Eliminamos las categorías anteriores
        $tema->categorias()->detach();

        // Guardamos las nuevas categorías del tema
        $input_categorias = $request->input('categorias') ?? [];
        foreach ($input_categorias as $categoria_id) {
            $categoria = Categoria::findOrFail($categoria_id);
            $tema->categorias()->save($categoria);
        }

        // Actualizamos o creamos la foto
        if ($archivo = $request->file('foto_nueva')) {            
        
            $ruta_foto = \Helper::almacenarFoto($tema, $archivo, $this->carpeta_fotos);
            
            if (!$tema->foto) {
                $foto = new Foto([
                    'ruta_foto' => $ruta_foto
                ]);

            }else{
                $foto = $tema->foto;
                $foto->ruta_foto = $ruta_foto;
            }
            $tema->foto()->save($foto);
        }
        $tema->update($entrada);

        return redirect('/temas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tema = Tema::findOrFail($id);

        // Eliminamos las categorías anteriores
        $tema->categorias()->detach();
        
        // Eliminamos la foto asociada al tema
        if ($foto = $tema->foto){
            File::delete($foto->ruta_foto);
            $tema->foto()->delete();
        }
        $tema->delete();

        Session::flash('tema_borrada', 'El tema ha sido eliminado con éxito');

        return redirect()->back();
    }
}