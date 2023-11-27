import jQuery from "jquery";
window.$ = window.jQuery = jQuery;

console.log("password.js loaded");

// La expresión regular para validar la contraseña
var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_.,|\\\/¿¡~¬[\]{};])[A-Za-z\d$@$!%*?&_.,|\\\/¿¡~¬[\]{};]{6,13}[^'\s]/;

// Función para manejar la validación de la contraseña
function handlePasswordValidation() {
    var password = $(this).val();
    console.log(password);

    if (pattern.test(password)) {
        $("#mss").html("Contrasenya vàlida").css({
            "color": "green",
            "border": "1px solid green",
            "border-radius": "3px",
            "margin-top": "5px",
            "padding": "5px",
            "max-width": "170px",  // Establecer un ancho máximo
            "text-align": "left"   // Alineado a la izquierda
        });
        // Quita el manejo del evento click en el botón (permitiendo el envío del formulario)
        $("#btnEnviar").prop("disabled", false);
    } else {
        $("#mss").html("Contrasenya invàlida").css({
            "color": "red",
            "border": "1px solid red",
            "border-radius": "3px",
            "margin-top": "5px",
            "padding": "5px",
            "max-width": "170px",  // Establecer un ancho máximo
            "text-align": "left"   // Alineado a la izquierda
        });
        // Deshabilita el botón de enviar si la contraseña no es válida
        $("#btnEnviar").prop("disabled", true);
    }
}

// Asigna el evento 'input' al campo de contraseña
$('#password').on('keyup', handlePasswordValidation);
export { handlePasswordValidation };
