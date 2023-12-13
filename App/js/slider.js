document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('slider');

    if (!slider) {
        console.error("No se encontró ningún elemento con el ID 'slider'");
        return;
    }

    // Configuración del slider
    const intervaloTiempo = 2000; // Intervalo de tiempo en milisegundos (2 segundos en este caso)
    let currentIndex = 0;

    function moverSlider() {
        const slides = slider.querySelectorAll('.slide');
        const numSlides = slides.length;

        if (numSlides < 2) {
            console.error("El slider debe tener al menos dos elementos con la clase 'slide'");
            return;
        }

        const imagenVisible = slides[currentIndex];
        const siguienteIndex = (currentIndex + 1) % numSlides;
        const imagenSiguiente = slides[siguienteIndex];

        // Inicia la animación cambiando la opacidad y la posición de las imágenes
        imagenVisible.style.transition = 'opacity 0.8s ease-in-out, transform 0.8s ease-in-out';
        imagenSiguiente.style.transition = 'opacity 0.8s ease-in-out, transform 0.8s ease-in-out';

        // Cambia la opacidad de la imagen actual a 0 y la traslada hacia la izquierda
        imagenVisible.style.opacity = 0;
        imagenVisible.style.transform = 'translateX(-100%)';

        // Espera a que termine la transición antes de ajustar los estilos
        setTimeout(() => {
            // Restaura los estilos y cambia la opacidad de la siguiente imagen a 1
            imagenVisible.style.transition = 'none';
            imagenVisible.style.opacity = 1;
            imagenVisible.style.transform = 'translateX(0)';
            imagenSiguiente.style.opacity = 1;

            // Cambia el índice para la siguiente iteración
            currentIndex = siguienteIndex;
        }, 800); // Ajusta el tiempo de espera según sea necesario
    }

    // Inicia el slider automáticamente
    setInterval(moverSlider, intervaloTiempo);

    // Llama a moverSlider una vez después de la carga del DOM
    moverSlider();
});
