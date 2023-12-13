export function mousevent() {
    // Agregar evento al pasar el ratón sobre el botón
    document.getElementById('infoButton').addEventListener('mouseover', function() {
        // Mostrar el contenedor de información
        document.getElementById('infoContainer').classList.remove('invisible');
    });

    // Agregar evento al quitar el ratón del botón
    document.getElementById('infoButton').addEventListener('mouseout', function() {
        // Ocultar el contenedor de información
        document.getElementById('infoContainer').classList.add('invisible');
    });
}

// Llama a la función para agregar los eventos
mousevent();