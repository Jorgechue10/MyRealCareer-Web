@extends("../layouts.plantilla")

@section("head")
    <link rel="stylesheet" type="text/css" href="css/welcome.css">
@endsection


@section("before__contenido")
<div class="banner">
    <img src="img/portada_con_logo.png" alt="Banner" class="banner_img">
    <div class="contenedor">
        <h2 class="banner__titulo">El mejor Modo Carrera a tu alcance</h2>
        <p class="banner__txt">Descárgalo ya y alcanza tus sueños</p>
    </div>
</div>
@endsection

@section("contenido")
    <section class="info">
        <article class="info__columna">
            <img src="img/welcome_info_1.jpg" alt="">
            <div class="info__txt">
                <h2 class="info__titulo">Crea tu propio club</h2>
                <p class="info__contenido">MyRealCareer es un juego de Android que permite simular las funciones de gestión un club de fútbol</p>
            </div>
        </article>
        <article class="info__columna">
            <img src="img/welcome_info_2.jpg" alt="" class="info__img">
            <div class="info__txt">
                <h2 class="info__titulo">Lleva a tu club a lo más alto</h2>
                <p class="info__contenido">Consigue los trofeos más valiosos y expande la firma del club por todo el mundo</p>
            </div>
        </article>
        <article class="info__columna">
            <img src="img/welcome_info_3.jpg" alt="" class="info__img">
            <div class="info__txt">
                <h2 class="info__titulo">Rastrea el mercado en busca de los mejores jugadores</h2>
                <p class="info__contenido">Muévete por el mercado y negocia por los jugadores a un buen precio</p>
            </div>
        </article>
        <article class="info__columna">
            <img src="img/welcome_info_4.png" alt="" class="info__img">
            <div class="info__txt">
                <h2 class="info__titulo">Maneja la plantilla</h2>
                <p class="info__contenido">Plantea las alineaciones y controla el estado físico y mental de los jugadores antes de saltar al césped</p>
            </div>
        </article>
        <article class="info__columna">
            <img src="img/welcome_info_5.jpg" alt="" class="info__img">
            <div class="info__txt">
                <h2 class="info__titulo">Contrata ojeadores para reclutar jóvenes promesas</h2>
                <p class="info__contenido">Los ojeadores se encargarán de descubrir los mayores talentos en los países destinados</p>
            </div>
        </article>
        <article class="info__columna">
            <img src="img/welcome_info_6.jpg" alt="" class="info__img">
            <div class="info__txt">
                <h2 class="info__titulo">Gestiona la cantera</h2>
                <p class="info__contenido">Invierte dinero en la cantera para conseguir una gran academia de jugadores</p>
            </div>
        </article>
        <article class="info__columna">
            <img src="img/welcome_info_7.png" alt="" class="info__img">
            <div class="info__txt">
                <h2 class="info__titulo">Busca patrocinadores y personaliza las equipaciones</h2>
                <p class="info__contenido">Contrata los patrocinadores más beneficiarios y personaliza las equipoaciones con sus logos</p>
            </div>
        </article>
    </section>
@endsection