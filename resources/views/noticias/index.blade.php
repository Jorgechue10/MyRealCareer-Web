@extends("../layouts.plantilla")

@section("head")
<link rel="stylesheet" type="text/css" href="/css/section_index.css">
<link rel="stylesheet" type="text/css" href="/css/noticias/noticias_index.css">
@endsection

@section("contenido")
    @if(Session::has('noticia_borrado'))
        <h3 id="objeto__borrar">{{ session('noticia_borrado') }}</h3>
    @endif
    <section>
        <span class="section__name">Noticias</span>
        @if (Auth::check() && Auth::user()->esAdmin())
            <a href="{{ route('noticias.create') }}" class="button" id="objeto__crear">Nuevo Noticia</a>
        @endif
        @forelse($noticias as $noticia)
            <article>
                @if (Auth::check() && Auth::user()->esAdmin())
                    <div class="opciones">
                        {!! Form::open(['method' => 'GET', 'route' => ['noticias.edit', $noticia->id]]) !!}
                            @csrf
                            {{ Form::button('', ['type' => 'submit', 'class' => 'icon-edit']) }}
                        {!! Form::close() !!}
                        {!! Form::model($noticia, ['method' => 'DELETE', 'action' => ['NoticiasController@destroy', $noticia->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
                            @csrf
                            {{ Form::button('', ['type' => 'submit', 'class' => 'icon-delete']) }}
                        {!! Form::close() !!}
                    </div>                    
                @endif                
                <a href="{{ route('noticias.show', $noticia->id) }}">
                    <div class="objeto__info">
                        <div class="objeto__img">
                        @if($noticia->foto)
                            <img src="{{ $noticia->foto->ruta_foto }}"/>
                        @else
                            <img src="images/noticias/default.png"/>
                        @endif
                        </div>
                        <div class="objeto__txt">
                            <span class="objeto__tiempo">Hace {{ $noticia->tiempo }}</span>
                            <h2 class="objeto__titulo">{{ $noticia->titulo }}</h2>
                        </div>
                    </div>
                </a>                    
            </article>
        @empty
            <p id="objeto__empty">No hay noticias para leer</p>
        @endforelse
    </section>
    <div id="paginacion">
        {{ $noticias->links() }}
    </div>
@endsection