// Agregar un objeto a favoritos mediante una llamada por AJAX
function likeClick(id, type, contador) {

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        url: "/likes/click",
        data: {id:id, type:type},
        success: function(msg) {
            //console.log(msg);
            if (seguidores = document.getElementById('seguidores')) {
                seguidores.textContent = msg['numeroLikes'];
            }

            var likes__icon = document.getElementById('likes__icon__'+contador);
            var likes__numero = document.getElementById('likes__numero__'+contador);
            likes__numero.textContent = msg['numeroLikes'];
            $color = msg['status'] ? "red" : "";
            likes__icon.style.color = $color;
            likes__numero.style.color = $color;
        },
        error: function (xhr) {
            if (xhr.status == 401) {
                window.location.href = '/login';
            }
        }
    });
    return false; // Se evita la redirección a la ruta de href
}