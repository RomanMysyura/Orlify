const video = document.getElementById('video');
const captureButton = document.getElementById('captureButton');
const canvas = document.getElementById('canvas');
const downloadLink = document.getElementById('downloadLink');
const screenshotsContainer = document.getElementById('screenshotsContainer');
const context = canvas.getContext('2d');
let isCameraOpen = false;

// Función para abrir/cerrar la cámara
function toggleCamera() {
    if (isCameraOpen) {
        // Detener la transmisión de la cámara
        const stream = video.srcObject;
        const tracks = stream.getTracks();

        tracks.forEach(track => track.stop());
        video.srcObject = null;

        // Ocultar el botón de captura, el enlace de descarga y las imágenes
        captureButton.style.display = 'none';
        downloadLink.style.display = 'none';
        screenshotsContainer.innerHTML = '';
    } else {
        // Obtener la corriente de la cámara y mostrarla en el elemento de video
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
                // Mostrar el botón de captura después de abrir la cámara
                captureButton.style.display = 'inline-block';
            })
            .catch((error) => {
                console.error('Error al acceder a la cámara:', error);
            });
    }

    // Cambiar el estado de la cámara
    isCameraOpen = !isCameraOpen;
}

// Capturar una foto cuando se hace clic en el botón
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