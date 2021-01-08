@extends("../layouts.plantilla")

@section("head")
<link rel="stylesheet" type="text/css" href="/css/section_create_edit.css">
<script src="/js/jquery-3.5.1.min.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/additional-methods.js"></script>
<script src="/js/noticias.js"></script>
<script src="/js/vista_previa_imagen.js"></script>
@endsection

@section("contenido")

    @if($errors->all())
        <div class="error">
            <span>Se han producido errores en el envío de datos:</span>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif 

    <a id="volver__link" class="icon-back" href="{{ route('noticias.index') }}"><span>Volver a Noticias</span></a>

    <h2>Nueva Noticia</h2>
    
    {!! Form::open(['id' => 'formulario', 'method' => 'POST', 'action' => 'NoticiasController@store', 'files' => true]) !!}
        @csrf

        {!! Form::label('titulo', 'Título'); !!}
        {!! Form::text('titulo'); !!}

        {!! Form::label('contenido', 'Contenido'); !!}
        {!! Form::textarea('contenido'); !!}

        {!! Form::label('foto', 'Foto'); !!}
        <img src="#" id="vista_previa" />
        {!! Form::file('foto'); !!}        

        {!! Form::submit('Crear noticia'); !!}
        {!! Form::reset('Borrar'); !!}

    {!! Form::close() !!}
@endsection