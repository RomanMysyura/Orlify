export function toggleCamera() {
    const video = document.getElementById('video');
    const captureButton = document.getElementById('captureButton');
    const canvas = document.getElementById('canvas');
    const downloadLink = document.getElementById('downloadLink');
    const screenshotsContainer = document.getElementById('screenshotsContainer');
    const context = canvas ? canvas.getContext('2d') : null;
    let isCameraOpen = false;


    // Capturar una foto quan es fa clic al botó
    if (canvas) {
        captureButton.addEventListener('click', () => {
            // Dibuixar el fotograma actual del vídeo al llenç
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Mostrar l'enllaç de descàrrega i configurar la imatge
            const imageDataURL = canvas.toDataURL('image/png');
            downloadLink.href = imageDataURL;
            downloadLink.download = 'captura.png';
            downloadLink.style.display = 'inline-block';

            // Crear un nou element img i afegir-lo al contenidor d'imatges capturades
            const img = document.createElement('img');
            img.src = imageDataURL;
            screenshotsContainer.prepend(img);
        });
    }
}
