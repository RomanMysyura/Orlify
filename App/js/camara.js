export function toggleCamera() {
    const video = document.getElementById('video');
    const captureButton = document.getElementById('captureButton');
    const canvas = document.getElementById('canvas');
    const downloadLink = document.getElementById('downloadLink');
    const screenshotsContainer = document.getElementById('screenshotsContainer');
    const context = canvas ? canvas.getContext('2d') : null;
    let isCameraOpen = false;

    // Resto del código ...

    // Capturar una foto cuando se hace clic en el botón
    if (canvas) {
        captureButton.addEventListener('click', () => {
            // Dibujar el fotograma actual del video en el lienzo
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Mostrar el enlace de descarga y configurar la imagen
            const imageDataURL = canvas.toDataURL('image/png');
            downloadLink.href = imageDataURL;
            downloadLink.download = 'captura.png';
            downloadLink.style.display = 'inline-block';

            // Crear un nuevo elemento img y agregarlo al contenedor de imágenes capturadas
            const img = document.createElement('img');
            img.src = imageDataURL;
            screenshotsContainer.prepend(img);
        });
    }
}
