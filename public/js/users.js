$(document).ready(function(){

    // Validación del formulario
    $('#formulario').validate({
        rules: {
            name: {
                required: true,
                maxlength: 50
            },
            email: {
                required: true,
                maxlength: 50,
                email: true
            },
            foto: {
                accept: "image/jpeg,image/jpg,image/png,image/gif,image/bmp,image/tiff"
            },
            foto_nueva: {
                accept: "image/jpeg,image/jpg,image/png,image/gif,image/bmp,image/tiff"
            }
        },
        messages: {
            name:{
                required: 'Campo obligatorio*',
                maxlength: 'Máximo {0} dígitos'
            },
            email:{
                required: 'Campo obligatorio*',
                maxlength: 'Máximo {0} dígitos',
                email: 'Formato de email incorrecto'
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