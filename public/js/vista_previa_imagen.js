$(document).ready(function(){

    $("#foto, #foto_nueva").change(function(){
        readURL(this);
    });

    mostrarImagen(false, null);

    $('#formulario').on('reset', function() {
        mostrarImagen(false, null);
    });

});

// Mostrar la imagen después de que el usuario la cargue en la web
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            mostrarImagen(true, e.target.result);
        }        
        reader.readAsDataURL(input.files[0]);
    }
}

// Función para mostrar/ocultar una imagen
function mostrarImagen(visible, src) {
    if (visible) {
        $('#vista_previa').css({"visibility": "visible", "margin": "8px 0"});
        $('#vista_previa').attr('src', src);
    }else{
        $('#vista_previa').css({"visibility": "hidden", "margin": "0"});
        $('#vista_previa').attr('src', '#');
    }
}