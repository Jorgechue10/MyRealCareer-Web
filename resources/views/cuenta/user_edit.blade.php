@extends("../layouts.plantilla")

@section("head")
<link rel="stylesheet" type="text/css" href="/css/section_create_edit.css">
<link rel="stylesheet" type="text/css" href="/css/cuenta/perfil.css">
<script src="/js/jquery-3.5.1.min.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/additional-methods.js"></script>
<script src="/js/users.js"></script>
<script src="/js/vista_previa_imagen.js"></script>
@endsection

@section("contenido")

    @include("../cuenta.nav_left")

    <div class="contenido">
        @include("../users.edit_layout")
    </div>
@endsection