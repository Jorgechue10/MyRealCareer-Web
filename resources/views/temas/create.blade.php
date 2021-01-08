@extends("../layouts.plantilla")

@section("head")
<link rel="stylesheet" type="text/css" href="/css/section_create_edit.css">
<script src="/js/jquery-3.5.1.min.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/additional-methods.js"></script>
<script src="/js/temas.js"></script>
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

    <a id="volver__link" class="icon-back" href="{{ route('temas.index') }}"><span>Volver a Temas</span></a>

    <h2>Nuevo Tema</h2>
    
    {!! Form::open(['id' => 'formulario', 'method' => 'POST', 'action' => 'TemasController@store', 'files' => true]) !!}
        @csrf

        {!! Form::label('asunto', 'Asunto'); !!}
        {!! Form::text('asunto'); !!}

        {!! Form::label('contenido', 'Contenido'); !!}
        {!! Form::textarea('contenido'); !!}

        {!! Form::label('categorias', 'Categorías (opcional)'); !!}
        @forelse($categorias as $categoria)
            {!! Form::checkbox('categorias[]', $categoria->id) !!}
            {{ $categoria->nombre }}<br />
        @empty
            <p id="objeto__empty">No hay categorías para elegir</p>
        @endforelse

        {!! Form::label('foto', 'Foto (opcional)'); !!}
        <img src="#" id="vista_previa" />
        {!! Form::file('foto'); !!}

        {!! Form::submit('Crear tema'); !!}
        {!! Form::reset('Borrar'); !!}

    {!! Form::close() !!}
@endsection