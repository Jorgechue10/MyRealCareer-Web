var btnMenu = document.getElementById('btn-menu');
var nav = document.getElementById('nav');
var nav__left = document.getElementById('nav__left');
var contenido = document.getElementById('contenido');
btnMenu.addEventListener('click', function(){
    nav.classList.toggle('mostrar');
    nav__left.classList.toggle('mostrar');
    contenido.classList.toggle('opacidad_fondo');
});

var btnPerfil = document.getElementById('btn-perfil');
var opcionesPerfil = document.getElementById('menu_item_perfil_opciones');
if (btnPerfil) {
    btnPerfil.addEventListener('click', function(){
        opcionesPerfil.classList.toggle('desplegar');
    });   
}