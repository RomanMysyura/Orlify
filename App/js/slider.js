const slider = document.getElementById('slider');

// Configuración del slider
const intervaloTiempo = 2000; // Intervalo de tiempo en milisegundos (2 segundos en este caso)

export function moverSlider() {
    const anchoSlide = document.querySelector('.slide').offsetWidth;
    slider.style.transition = 'transform 0.8s ease-in-out';
    slider.style.transform = `translateX(-${anchoSlide}px)`;

    // Cuando la animación de transición ha terminado, mueve el primer slide al final
    setTimeout(() => {
        const primerSlide = slider.firstElementChild;
        slider.appendChild(primerSlide);
        slider.style.transition = 'none';
        slider.style.transform = 'translateX(0)';
    }, 800); // Ajusta el tiempo de espera a la duración de la transición
}

// Inicia el slider automáticamente
setInterval(moverSlider, intervaloTiempo);
