document.addEventListener('DOMContentLoaded', function () {
    const $camButton = document.getElementById('cam');
    const $captureButton = document.getElementById('capture');
    const $video = document.getElementById('video');
    const $canvas = document.getElementById('canvas');
    const $form = document.getElementById('myForm');

    let isCameraOpen = false;

    const tieneSoporteUserMedia = () =>
        !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia);

    const _getUserMedia = (...arguments) =>
        (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);

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
                    console.log("Permiso denegado o error: ", error);
                }
            );
        } else {
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

    $camButton.addEventListener('click', () => {
        mostrarStream();
    });

    $captureButton.addEventListener('click', () => {
        $video.pause();
        let contexto = $canvas.getContext("2d");
        $canvas.width = $video.videoWidth;
        $canvas.height = $video.videoHeight;
        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);
        let foto = $canvas.toDataURL();
        let enlace = document.createElement('a');
        enlace.download = "foto.png";
        enlace.href = foto;
        enlace.click();
        $video.play();
    });

    $form.addEventListener('submit', function (event) {
        if (isCameraOpen) {
            event.preventDefault();
            alert('Por favor, cierra la cámara antes de enviar el formulario.');
        }
    });
});


