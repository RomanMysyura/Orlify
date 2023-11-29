export default function displayFileName() {
    var dropzoneInput = document.getElementById("dropzone-file");
    var fileNameElement = document.getElementById("file-name");

    if (dropzoneInput.files.length > 0) {
        fileNameElement.innerText = dropzoneInput.files[0].name;
    } else {
        fileNameElement.innerText = "JPG, JPEG i PNG";
    }
}

export function initDropFile() {
    document.addEventListener("DOMContentLoaded", function () {
        var dropzoneLabel = document.getElementById("dropzone-label");
        var dropzoneInput = document.getElementById("dropzone-file");
    
        dropzoneLabel.addEventListener("dragover", function (e) {
            e.preventDefault();
            dropzoneLabel.classList.add("border-blue-500");
        });
    
        dropzoneLabel.addEventListener("dragleave", function () {
            dropzoneLabel.classList.remove("border-blue-500");
        });
    
        dropzoneLabel.addEventListener("drop", function (e) {
            e.preventDefault();
    
            dropzoneLabel.classList.remove("border-blue-500");
    
            var files = e.dataTransfer.files;
    
            if (files.length > 0) {
                dropzoneInput.files = files;
                displayFileName();
            }
        });
    });
}

