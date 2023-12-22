document.addEventListener('DOMContentLoaded', function () {
    const $camButton = document.getElementById('cam');
    const $captureButton = document.getElementById('capture');
    const $video = document.getElementById('video');
    const $canvas = document.getElementById('canvas');
    const $form = document.getElementById('myForm');

    let isCameraOpen = false;

    // Comprova si el navegador té suport per a User Media
    const tieneSoporteUserMedia = () =>
        !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia);

    // Funció utilitat per obtenir el mitjà de l'usuari
    const _getUserMedia = (...arguments) =>
        (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);

    // Mostra el stream de la càmera
    const mostrarStream = () => {
        if (!isCameraOpen) {
            _getUserMedia(
                { video: true },
                (streamObtenido) => {
                    $video.style.display = 'block';
                    $video.srcObject = streamObtenido;
                    $video.play();
                    $captureButton.style.display = 'block';
                    $camButton.textContent = 'Tancar càmera';
                    isCameraOpen = true;
                },
                (error) => {
                    console.log("Permís denegat o error: ", error);
                }
            );
        } else {
            // Tancar la càmera si ja està oberta
            if ($video.srcObject) {
                const tracks = $video.srcObject.getTracks();
                tracks.forEach(track => track.stop());
            }
            $video.style.display = 'none';
            $captureButton.style.display = 'none';
            $camButton.textContent = 'Obrir càmera';
            isCameraOpen = false;
        }
    };

    // Gestiona el clic al botó de la càmera
    $camButton.addEventListener('click', () => {
        mostrarStream();
    });

    // Gestiona el clic al botó de captura
    $captureButton.addEventListener('click', () => {
        // Pausa el vídeo abans de capturar una imatge
        $video.pause();
        let contexto = $canvas.getContext("2d");
        $canvas.width = $video.videoWidth;
        $canvas.height = $video.videoHeight;
        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);
        // Converteix la imatge a format base64 i crea un enllaç de descàrrega
        let foto = $canvas.toDataURL();
        let enlace = document.createElement('a');
        enlace.download = "foto.png";
        enlace.href = foto;
        enlace.click();
        // Reprodueix el vídeo després de capturar la imatge
        $video.play();
    });

    // Gestiona l'enviament del formulari
    $form.addEventListener('submit', function (event) {
        if (isCameraOpen) {
            // Evita l'enviament del formulari si la càmera està oberta
            event.preventDefault();
            alert('Si us plau, tanca la càmera abans d\'enviar el formulari.');
        }
    });
});
