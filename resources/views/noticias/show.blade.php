{{ Session::put('modelo', 'Noticia') }}
{{ Session::put('modelo_id', $noticia->id) }}


@extends("../layouts.plantilla")

@section("head")
    <link rel="stylesheet" type="text/css" href="/css/noticias/noticias_show.css">
    <link rel="stylesheet" type="text/css" href="/css/comentarios.css">
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

    <a id="volver__link" class="icon-back" href="{{ route('noticias.index') }}"><span>Volver a Noticias</span></a>

    @php($contador=0)
    <section class="noticia">
        @if($noticia)
            <article class="noticia__articulo">
                <div class="noticia__img">
                    @if($noticia->foto)
                        <img src="/{{ $noticia->foto->ruta_foto }}"/>
                    @else
                        <img src="/images/noticias/default.png"/>
                    @endif
                </div>
                <h1>{{ $noticia->titulo }}</h1>
                <span class="noticia__fecha">{{ $noticia->created_at->format('d/m/Y') }}</span>
                <a href="#" onclick="return likeClick({{ $noticia->id }}, 2, {{$contador}})">
                    @if (Auth::check() && in_array(Auth::user()->id, $noticia->likes->pluck('user_id')->all()))
                        @php($like_style = "color: red")
                    @else
                        @php($like_style = '')
                    @endif
                    <span id="likes__icon__{{$contador}}" class="icon-like" style='{{ $like_style }}'></span>
                    <span id="likes__numero__{{$contador}}" class="likes__numero" style='{{ $like_style }}'>{{ $noticia->likes->count() }}</span>
                </a>
                <p class="noticia__contenido">{!! nl2br(e($noticia->contenido)) !!}</p>
            </article>
        @endif      
    </section>

    @include("../comentarios.comentarios_seccion", ['objeto' => $noticia])

@endsection