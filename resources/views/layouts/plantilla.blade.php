<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<title>My Dream Career</title>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="/css/fontello.css">
    <link rel="stylesheet" type="text/css" href="/css/header.css">	
    <link rel="stylesheet" type="text/css" href="/css/styles.css">	
    <link rel="stylesheet" type="text/css" href="/css/footer.css">
	<link rel="icon" type="image/png" href="/img/icon.png">
    @yield("head")
</head>
<body>
	<header class="header">
		<div class="contenedor">
			<span class="icon-menu" id="btn-menu"></span>
			<a id="header__logo" href="{{ route('welcome') }}">
				<img src="/img/icon.png" alt="Icono Index">
			</a>
			<h1 id="header__titulo">My Dream Career</h1>
			
			<nav id="nav" class="nav">
				<div id="nav__left" class="nav__left">
					<ul class="menu">
						<li><a class="menu__link" href="{{ route('noticias.index') }}">Noticias</a></li>
						<li><a class="menu__link" href="{{ route('temas.index') }}">Foro</a></li>
						<li><a class="menu__link" href="{{ route('ayuda') }}">FAQ</a></li>
						@if(Auth::check())
							<li><a class="menu__link" href="{{ route('users.show', Auth::user()->id) }}">Mi espacio</a></li>
						@else
							<li><a class="menu__link" href="{{ route('login') }}">Mi espacio</a></li>
						@endif
					</ul>
				</div>
				<div id="nav__right" class="nav__right">
					<ul class="menu">
						<!--<li id="menu_item_busqueda">
							<form action="#" id="form_busqueda" method="post">
								<input type="search" id="menu_busqueda" placeholder="Search...">
							</form>
						</li>
						<li id="menu_item_busqueda2"><a class="menu__link icon-search" href="#"></a>
						</li>
						<li id="menu_item_idioma"><a class="menu__link icon-language" href="#"></a>
						</li>-->
						<li id="menu_item_perfil">
                            @if (Route::has('login'))
								@auth
									<span id="btn-perfil" class="menu__link">{{  Auth::user()->name  }}</span>
									<ul id="menu_item_perfil_opciones">										
										<li><a class="menu__link" href="{{ route('home') }}">Perfil</a></li>
										<li>
											<a class="menu__link" href="{{ route('logout') }}" 
												onclick="event.preventDefault(); 
												document.getElementById('logout-form').submit();">
												{{ __('Logout') }}
											</a>

											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
												@csrf
											</form>
										</li>
									</ul>
                                @else
                                    <a class="menu__link icon-user" href="{{ route('login') }}">
								        <span id="menu_item_perfil_texto">Log In</span>
							        </a>
                                @endauth
                            @endif
                        </li>
					</ul>
				</div>
			</nav>
		</div>
	</header>
	@yield("before__contenido")
	<main>
		<div class="contenedor">
            @yield("contenido")
        </div>
	</main>	
	<footer>
		<div class="contenedor">
			<div class="columna__uno">
				<h3>My Real Career</h3>
				<p>Es un juego disponible para dispositivos Android cuya finalidad es dirigir un equipo de fútbol.</p>
			</div>
			<div class="columna__dos">
				<h2>Redes Sociales</h2>
				<p>Siguenos en nuestras redes sociales para mantenerte informado de todas novedades</p><br />
				<a href="https://es-es.facebook.com/"><i class="icon-facebook"></i></a>
				<a href="https://twitter.com/"><i class="icon-twitter"></i></a>
				<a href="https://www.instagram.com/"><i class="icon-instagram"></i></a>
				<a href="https://myaccount.google.com/intro/profile"><i class="icon-googleplus"></i></a>
			</div>
			<div class="columna__tres">
				<h2>Secciones</h2>
				<ul>
					<li><a href="{{ route('welcome') }}">Inicio</a></li>
					<li><a href="{{ route('noticias.index') }}">Noticias</a></li>
					{{--<li><a href="{{ route('temas.index') }}">Foro</a></li>
					<li><a href="{{ route('ayuda') }}">FAQ</a></li>
					@if(Auth::check())
						<li><a href="{{ route('users.show', Auth::user()->id) }}">Mi espacio</a></li>
					@else
						<li><a href="{{ route('login') }}">Mi espacio</a></li>
					@endif --}}
				</ul>
			</div>
			<div class="columna__cuatro">
				<ul>
					<li><a href="{{ route('temas.index') }}">Foro</a></li>
					<li><a href="{{ route('ayuda') }}">FAQ</a></li>
					@if(Auth::check())
						<li><a href="{{ route('users.show', Auth::user()->id) }}">Mi espacio</a></li>
					@else
						<li><a href="{{ route('login') }}">Mi espacio</a></li>
					@endif
				</ul>
			</div>					
		</div>
		<div class="footer__bottom">
			<a href="{{ route('welcome') }}"><img class="footer__logo" src="/img/icon_white.png" alt="Icon"></a>
			<p class="footer__copyright">&copy; 2021, My Real Career. Todos los derechos reservados.</p>
		</div>
	</footer>
	@yield("scripts")
	<script src="/js/menu.js"></script>
</body>

</html>