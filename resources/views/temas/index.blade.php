@php($nombre_categoria = $nombre_categoria ?? null)

@extends("../layouts.plantilla")

@section("head")
<link rel="stylesheet" type="text/css" href="/css/section_index.css">
<link rel="stylesheet" type="text/css" href="/css/temas/tema.css">
@endsection

@section("contenido")
    @if(Session::has('tema_borrado'))
        <h3 id="objeto__borrar">{{ session('tema_borrado') }}</h3>
    @endif

    @if($nombre_categoria)
        <a class="icon-back" href="{{ route('temas.index') }}"><span>Volver a Temas</span></a><br /><br />
    @endif
    
    <section>
        <span class="section__name">Temas
            @if($nombre_categoria)
                - Categoría: {{ $nombre_categoria }}
            @endif
        </span>
        @if (Auth::check())
            <a href="{{ route('temas.create') }}" class="button" id="objeto__crear">Nuevo Tema</a>
        @endif
        @forelse($temas as $tema)
            <article>
                @if (Auth::check() && Auth::user()->esAdmin())
                    <div class="opciones">
                        {!! Form::open(['method' => 'GET', 'route' => ['temas.edit', $tema->id]]) !!}
                            @csrf
                            {{ Form::button('', ['type' => 'submit', 'class' => 'icon-edit']) }}
                        {!! Form::close() !!}
                        {!! Form::model($tema, ['method' => 'DELETE', 'action' => ['TemasController@destroy', $tema->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
                            @csrf
                            {{ Form::button('', ['type' => 'submit', 'class' => 'icon-delete']) }}
                        {!! Form::close() !!}
                    </div>                    
                @endif
                
                @include("../layouts.tema")
            </article>
        @empty
            <p id="objeto__empty">No hay temas para leer</p>
        @endforelse
    </section>
    <div id="paginacion">
        {{ $temas->links() }}
    </div>
@endsection