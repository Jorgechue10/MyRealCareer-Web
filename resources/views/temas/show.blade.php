{{ Session::put('modelo', 'Tema') }}
{{ Session::put('modelo_id', $tema->id) }}


@extends("../layouts.plantilla")

@section("head")
    <link rel="stylesheet" type="text/css" href="/css/temas/temas_show.css">
    <link rel="stylesheet" type="text/css" href="/css/comentarios.css">
    <link rel="stylesheet" type="text/css" href="/css/temas/tema.css">
    <script src="/js/jquery-3.5.1.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
	<script src="/js/additional-methods.js"></script>
    <script src="/js/comentarios.js"></script>
    <script src="/js/likes.js"></script>
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

    @php($contador=0)
    @include("../layouts.tema", ["show" => true])

    @include("../comentarios.comentarios_seccion", ['objeto' => $tema])

@endsection