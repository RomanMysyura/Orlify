document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('slider');

    if (!slider) {
        console.error("No se encontró ningún elemento con el ID 'slider'");
        return;
    }

    const slides = Array.from(slider.querySelectorAll('.slide'));
    const anchoSlide = slides[0].offsetWidth;

    if (slides.length < 2) {
        console.error("El slider debe tener al menos dos elementos con la clase 'slide'");
        return;
    }

    function moverSlider() {
        slider.style.transition = `transform 0.8s ease-in-out`;
        slider.style.transform = `translateX(-${anchoSlide}px)`;

        function transitionEndHandler() {
            slider.style.transition = 'none';
            slider.style.transform = 'translateX(0)';

            const removedSlide = slides.shift();
            slides.push(removedSlide);

            slides.forEach((slide, index) => {
                slide.style.left = `${index * anchoSlide}px`;
            });

            slider.removeEventListener('transitionend', transitionEndHandler);
        }

        slider.addEventListener('transitionend', transitionEndHandler);
    }

    setInterval(() => {
        moverSlider();
    }, 2000);
});
