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

    <h2>Editar Tema</h2>

    {!! Form::model($tema, ['id' => 'formulario', 'method' => 'PATCH', 'action' => ['TemasController@update', $tema->id], 'files' => true]) !!}
        @csrf

        {!! Form::label('asunto', 'Asunto'); !!}
        {!! Form::text('asunto'); !!}

        {!! Form::label('contenido', 'Contenido'); !!}
        {!! Form::textarea('contenido'); !!}
        
        {!! Form::label('categorias', 'Categorías (opcional)'); !!}
        @forelse($categorias as $categoria)
            @if (in_array($categoria->id, $tema->categorias->pluck('categoria_id')->all()))
                {!! Form::checkbox('categorias[]', $categoria->id, true) !!}
            @else
                {!! Form::checkbox('categorias[]', $categoria->id) !!}
            @endif
            {{ $categoria->nombre }}<br />
        @empty
            <p id="objeto__empty">No hay categorías para elegir</p>
        @endforelse

        @if($tema->foto)
            {!! Form::label('foto', 'Foto Actual'); !!}
            <img src="{{ '/'.$tema->foto->ruta_foto }}" />
        @endif
        {!! Form::label('foto_nueva', 'Foto Nueva (opcional)'); !!}
        <img src="#" id="vista_previa" />
        {!! Form::file('foto_nueva'); !!}

        {!! Form::submit('Editar tema'); !!}
        {!! Form::reset('Borrar'); !!}

    {!! Form::close() !!}
@endsection