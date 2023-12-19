// Importa jQuery com a dependència i el fa accessible globalment
import jQuery from "jquery";
window.$ = window.jQuery = jQuery;

// Registra la càrrega del fitxer password.js a la consola
console.log("password.js carregat");

// Expressió regular per validar la contrasenya
var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&_.,|\\\/¿¡~¬[\]{};])[A-Za-z\d$@$!%*?&_.,|\\\/¿¡~¬[\]{};]{6,13}[^'\s]/;

// Funció per gestionar la validació de la contrasenya
function handlePasswordValidation() {
    var password = $(this).val();
    console.log(password);

    if (pattern.test(password)) {
        // Mostra un missatge indicant que la contrasenya és vàlida
        $("#mss").html("Contrasenya vàlida").css({
            "color": "green",
            "border": "1px solid green",
            "border-radius": "3px",
            "margin-top": "5px",
            "padding": "5px",
            "max-width": "170px",  // Estableix un amplada màxima
            "text-align": "left"   // Alineat a l'esquerra
        });
        // Desactiva l'event de clic al botó (permetent l'enviament del formulari)
        $("#btnEnviar").prop("disabled", false);
    } else {
        // Mostra un missatge indicant que la contrasenya és invàlida
        $("#mss").html("Contrasenya invàlida").css({
            "color": "red",
            "border": "1px solid red",
            "border-radius": "3px",
            "margin-top": "5px",
            "padding": "5px",
            "max-width": "170px",  // Estableix un amplada màxima
            "text-align": "left"   // Alineat a l'esquerra
        });
        // Desactiva el botó d'enviament si la contrasenya no és vàlida
        $("#btnEnviar").prop("disabled", true);
    }
}

// Assigna l'event 'input' al camp de contrasenya
$('#password').on('keyup', handlePasswordValidation);

// Exporta la funció handlePasswordValidation
export { handlePasswordValidation };
