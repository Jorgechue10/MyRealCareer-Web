@extends("../layouts.plantilla")

@section("head")
<link rel="stylesheet" type="text/css" href="/css/section_index.css">
<link rel="stylesheet" type="text/css" href="/css/noticias/noticias_index.css">
<link rel="stylesheet" type="text/css" href="/css/cuenta/perfil.css">
@endsection

@section("contenido")

    @include("../cuenta.nav_left")

    <div class="contenido">
        @include("../noticias.index_layout")
    </div>
@endsection