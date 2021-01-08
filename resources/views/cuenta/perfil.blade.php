@extends("../layouts.plantilla")

@section("head")
<link rel="stylesheet" type="text/css" href="/css/section_create_edit.css">
<link rel="stylesheet" type="text/css" href="/css/cuenta/perfil.css">
<script src="/js/jquery-3.5.1.min.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/additional-methods.js"></script>
<script src="/js/likes.js"></script>
@endsection

@section("contenido")

    @include("../cuenta.nav_left")

    <div class="contenido">        
        <h2>Detalles de usuario</h2>
        <div class="datos">
            <div class="info">
                <span class="info__titulo">Nombre</span>
                <span class="info__contenido">{{ $user->name }}</span>
                <span class="info__titulo">Email</span>
                <span class="info__contenido">{{ $user->email }}</span>
                <span class="info__titulo">Siguiendo</span>
                <span class="info__contenido"><a href="{{ route('users.siguiendo', $user->id) }}">{{ $user->siguiendo->count() }}</a></span>
                <span class="info__titulo">Seguidores</span>
                <span class="info__contenido" id="seguidores"><a href="{{ route('users.seguidores', $user->id) }}">{{ $user->seguidores->count() }}</a></span>
                <span class="info__titulo"><a href="{{ route('users.noticias_favoritos', $user->id) }}">Noticias favoritas</a></span><br />
                <span class="info__titulo"><a href="{{ route('users.temas_publicados', $user->id) }}">Temas publicados</a></span><br />
                <span class="info__titulo"><a href="{{ route('users.temas_favoritos', $user->id) }}">Temas favoritos</a></span><br />
            </div> 
            <div class="user__foto">
                @if($user->foto)
                    <img class="user__img" src="/{{ $user->foto->ruta_foto }}"/>
                @else
                    <img class="user__img" src="/images/users/default.jpg"/>
                @endif
                <br />
                @if(Auth::user()->id === $user->id)
                    <a href="{{ route('users.edit', $user->id) }}" class="button">Editar usuario</a>
                    {!! Form::model($user, ['method' => 'DELETE', 'action' => ['UsersController@destroy', $user->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
                        @csrf
                        {!! Form::submit('Eliminar cuenta'); !!}
                    {!! Form::close() !!}
                @else
                    @php($contador = 0)
                    <a href="#" onclick="return likeClick({{ $user->id }}, 1, {{$contador}})">
                        @if (Auth::check() && in_array(Auth::user()->id, $user->seguidores->pluck('user_id')->all()))
                            @php($like_style = "color: red")
                        @else
                            @php($like_style = '')
                        @endif
                        <span id="likes__icon__{{$contador}}" class="icon-like" style='{{ $like_style }}'></span>
                        <span id="likes__numero__{{$contador}}" class="likes__numero" style='{{ $like_style }}'>{{ $user->seguidores->count() }}</span>
                    </a>
                @endif                
            </div>           
        </div>
    </div>
@endsection