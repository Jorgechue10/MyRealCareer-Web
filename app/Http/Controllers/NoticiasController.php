<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NoticiaRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Noticia;
use App\Foto;

class NoticiasController extends Controller
{
    // Carpeta donde se almacenan las fotos de las noticias
    private $carpeta_fotos = 'images/noticias/';

    // Los usuarios que no sean administradores sólo podrán leer las noticias
    public function __construct() {
        $this->middleware('EsAdmin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticias = Noticia::orderBy('created_at', 'DESC')->paginate(8);
        return view('noticias.index', compact('noticias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('noticias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\NoticiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticiaRequest $request)
    {
        $entrada = $request->all();
        $noticia = Noticia::create($entrada);        
        
        // Guardar foto
        if ($archivo = $request->file('foto')) {            
           
            $ruta_foto =  \Helper::almacenarFoto($noticia, $archivo, $this->carpeta_fotos);

            $foto = new Foto([
                'ruta_foto' => $ruta_foto
            ]);

            $noticia->foto()->save($foto);            
        }

        return redirect('/noticias');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $noticia = Noticia::findOrFail($id);

        return view('noticias.show', compact('noticia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);

        return view('noticias.edit', compact('noticia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\NoticiaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NoticiaRequest $request, $id)
    {
        $noticia = Noticia::findOrFail($id);
        $entrada = $request->all();       
        
        // Actualizamos o creamos la foto
        if ($archivo = $request->file('foto_nueva')) {            
        
            $ruta_foto = \Helper::almacenarFoto($noticia, $archivo, $this->carpeta_fotos);
            
            if (!$noticia->foto) {
                $foto = new Foto([
                    'ruta_foto' => $ruta_foto
                ]);

            }else{
                $foto = $noticia->foto;
                $foto->ruta_foto = $ruta_foto;
            }
            $noticia->foto()->save($foto);
        }
        $noticia->update($entrada);

        return redirect('/noticias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $noticia = Noticia::findOrFail($id);
        
        if ($foto = $noticia->foto){
            File::delete($foto->ruta_foto);
            $noticia->foto()->delete();
        }
        $noticia->delete();

        Session::flash('noticia_borrada', 'La noticia ha sido eliminada con éxito');

        return redirect()->back();
    }
}
