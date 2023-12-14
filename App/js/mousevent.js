export function setupMouseEvents() {
    const infoButton = document.getElementById('infoButton');
    const infoContainer = document.getElementById('infoContainer');

    // Verificar si los elementos existen antes de agregar eventos
    if (infoButton && infoContainer) {
        // Agregar evento al pasar el ratón sobre el botón
        infoButton.addEventListener('mouseover', function() {
            // Mostrar el contenedor de información
            infoContainer.classList.remove('invisible');
        });

        // Agregar evento al quitar el ratón del botón
        infoButton.addEventListener('mouseout', function() {
            // Ocultar el contenedor de información
            infoContainer.classList.add('invisible');
        });
    }
}

// Llama a la función para agregar los eventos
setupMouseEvents();
