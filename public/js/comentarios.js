$(document).ready(function(){

    funcionesFormularios();
});

function funcionesFormularios() {
    $('form').each(function() {
        var form = $(this);

        // Validación de los formularios
        form.validate({
            rules: {
                contenido: {
                    required: true,
                    maxlength: 2000
                }
            },
            messages: {
                contenido:{
                    required: 'Campo obligatorio*',
                    maxlength: 'Máximo {0} dígitos'
                },
            },
            // Se posiciona en el primer elemento no valido
            onfocusout: false,
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {                    
                    validator.errorList[0].element.focus();
                }
            }
        });
        form.on('submit', function(e) {
            // Si la validación no es correcta, no se ejecuta la llamada
            if(!form.valid()) return false;

            e.preventDefault();
            var parent_id = form.find('input[name="parent_id"]').val();
            if (parent_id === undefined) parent_id = 0;
            var contenido = form.find('textarea').val();
            publicarComentario(parent_id, contenido);
        });        
    });
}

// Publicar un comentario mediante una llamada por AJAX
function publicarComentario(parent_id, contenido) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $.ajax({
        type: "POST",
        url: "/comentarios/"+parent_id,
        data: {contenido:contenido},
        success: function(response) {
            //console.log(response);
            var id_respuesta = $('.respuesta:visible').attr('id');
            $('#comentarios').empty().html(response);
            if (id_respuesta !== undefined && parent_id !==0) mostrarComentarios(id_respuesta);
            funcionesFormularios();            
        },
        error: function (xhr) {
            if (xhr.status == 401) {
                window.location.href = '/login';
            }
        }
    });
}

// Desplegar el div con las repuestas de los comentarios
function mostrarComentarios(id) {
    //console.log(id);
    if (typeof id === "number"){
        id = "respuesta__" + id;
    }
    $("div#"+id).slideToggle();
    $("div.respuesta:not(#"+id+")").slideUp();
}