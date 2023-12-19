// Exporta la funció per mostrar el nom del fitxer
export default function displayFileName() {
    // Obté l'element d'entrada de la zona de l'arrossegament
    var dropzoneInput = document.getElementById("dropzone-file");
    // Obté l'element del nom del fitxer
    var fileNameElement = document.getElementById("file-name");

    // Comprova si els elements s'han trobat
    if (dropzoneInput && fileNameElement) {
        // Comprova si hi ha fitxers seleccionats
        if (dropzoneInput.files.length > 0) {
            // Actualitza el contingut amb el nom del primer fitxer seleccionat
            fileNameElement.innerText = dropzoneInput.files[0].name;
        } else {
            // Mostra un missatge per a fitxers JPG, JPEG i PNG quan no hi ha cap fitxer seleccionat
            fileNameElement.innerText = "JPG, JPEG i PNG";
        }
    }
}

// Exporta la funció per inicialitzar la zona de l'arrossegament de fitxers
export function initDropFile() {
    document.addEventListener("DOMContentLoaded", function () {
        // Obté l'etiqueta de la zona de l'arrossegament
        var dropzoneLabel = document.getElementById("dropzone-label");
        // Obté l'entrada de la zona de l'arrossegament
        var dropzoneInput = document.getElementById("dropzone-file");

        // Comprova si els elements s'han trobat
        if (dropzoneLabel && dropzoneInput) {
            // Afegeix un event listener per al dragover (arrossegar sobre)
            dropzoneLabel.addEventListener("dragover", function (e) {
                e.preventDefault();
                dropzoneLabel.classList.add("border-blue-500");
            });

            // Afegeix un event listener per al dragleave (arrossegar fora)
            dropzoneLabel.addEventListener("dragleave", function () {
                dropzoneLabel.classList.remove("border-blue-500");
            });

            // Afegeix un event listener per al drop (alliberar)
            dropzoneLabel.addEventListener("drop", function (e) {
                e.preventDefault();

                // Elimina la classe d'estil en arrossegar
                dropzoneLabel.classList.remove("border-blue-500");

                // Obté els fitxers deixats a la zona de l'arrossegament
                var files = e.dataTransfer.files;

                // Comprova si hi ha fitxers
                if (files.length > 0) {
                    // Assigna els fitxers a l'entrada de la zona de l'arrossegament i mostra el nom del fitxer
                    dropzoneInput.files = files;
                    displayFileName();
                }
            });
        }
    });
}
