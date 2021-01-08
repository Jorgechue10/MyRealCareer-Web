<div class="nav__left">
    <ul>
        <li class="nav__left__list"><a href="{{ route('users.show', Auth::user()->id) }}">Perfil</a></li>
        <li class="nav__left__list"><a href="{{ route('users.siguiendo', Auth::user()->id) }}">Siguiendo</a></li>
        <li class="nav__left__list"><a href="{{ route('users.seguidores', Auth::user()->id) }}">Seguidores</a></li>
        <li class="nav__left__list"><a href="{{ route('users.noticias_favoritos', Auth::user()->id) }}">Noticias favoritas</a></li>
        <li class="nav__left__list"><a href="{{ route('users.temas_publicados', Auth::user()->id) }}">Temas publicados</a></li>
        <li class="nav__left__list"><a href="{{ route('users.temas_favoritos', Auth::user()->id) }}">Temas favoritos</a></li>
    </ul>
</div>