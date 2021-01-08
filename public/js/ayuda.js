// Script encargado de mostrar las respuestas en la sección FAQ
$(document).ready(function(){

    const items = document.querySelectorAll(".accordion a");

    function toggleAccordion(){
        this.classList.toggle('active');
        this.nextElementSibling.classList.toggle('active');
    }

    items.forEach(item => item.addEventListener('click', toggleAccordion));
});