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

    <h2>Editar Noticia</h2>

    {!! Form::model($noticia, ['id' => 'formulario', 'method' => 'PATCH', 'action' => ['NoticiasController@update', $noticia->id], 'files' => true]) !!}
        @csrf

        {!! Form::label('titulo', 'Título'); !!}
        {!! Form::text('titulo'); !!}

        {!! Form::label('contenido', 'Contenido'); !!}
        {!! Form::textarea('contenido'); !!}
        
        {!! Form::label('foto', 'Foto Actual'); !!}
        <img src="{{ $noticia->foto ? '/'.$noticia->foto->ruta_foto : '/images/default.jpg'}}" />
        {!! Form::label('foto_nueva', 'Foto Nueva (opcional)'); !!}
        <img src="#" id="vista_previa" />
        {!! Form::file('foto_nueva'); !!}

        {!! Form::submit('Editar noticia'); !!}
        {!! Form::reset('Borrar'); !!}

    {!! Form::close() !!}
@endsection