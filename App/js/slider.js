document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('slider');
    const sliderList = document.querySelector('[x-ref="logos"]');
    const intervaloTiempo = 2000; // Intervalo de tiempo en milisegundos (2 segundos en este caso);

    function moverSlider() {
        const primerSlide = sliderList.firstElementChild.cloneNode(true);

        // Aplica un desplazamiento más largo hacia la izquierda al slide clonado
        primerSlide.style.transform = 'translateX(-50px)';

        // Inserta el slide clonado al final
        sliderList.appendChild(primerSlide);

        // Aplica un desplazamiento más largo hacia la izquierda al resto de los slides
        Array.from(sliderList.children).forEach(function (slide) {
            slide.style.transition = 'transform 0.8s ease-in-out'; // Duración de la transición
            slide.style.transform = 'translateX(-103px)';
        });

        // Elimina el primer slide después de un breve retraso (800 ms)
        setTimeout(function () {
            sliderList.removeChild(sliderList.firstElementChild);

            // Restablece el estilo de transformación para el resto de los slides
            Array.from(sliderList.children).forEach(function (slide) {
                slide.style.transition = 'none';
                slide.style.transform = 'translateX(0)';
            });
        }, 800);
    }

    // Inicia el slider automáticamente y repite la animación infinitamente
    setInterval(moverSlider, intervaloTiempo);
});
