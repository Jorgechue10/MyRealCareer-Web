$(document).ready(function(){

    // Validación del formulario
    $('#formulario').validate({
        rules: {
            asunto: {
                required: true,
                maxlength: 255
            },
            contenido: {
                required: true,
                maxlength: 2000
            },
            foto: {
                accept: "image/jpeg,image/jpg,image/png,image/gif,image/bmp,image/tiff"
            },
            foto_nueva: {
                accept: "image/jpeg,image/jpg,image/png,image/gif,image/bmp,image/tiff"
            }
        },
        messages: {
            asunto:{
                required: 'Campo obligatorio*',
                maxlength: 'Máximo {0} dígitos'
            },
            contenido:{
                required: 'Campo obligatorio*',
                maxlength: 'Máximo {0} dígitos'
            },            
            foto: {
                accept: 'Sólo están permitidos los formatos: jpeg, png, gif, bmp, tiff.'
            },            
            foto_nueva: {
                accept: 'Sólo están permitidos los formatos: jpeg, png, gif, bmp, tiff.'
            }
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
});