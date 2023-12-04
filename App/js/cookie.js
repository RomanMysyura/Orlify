    // Function to set a cookie
// Function to set a cookie with SameSite=None and Secure
export default function setCookie(name, value, days) {
    var expires = "";
    var sameSite = "; SameSite=None ;Secure"; 

    // Añade Secure si estás utilizando HTTPS
    var secureFlag = location.protocol === "https:" ? "; Secure" : "";

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }

    document.cookie = name + "=" + value + expires + sameSite + secureFlag + "; path=/";
}

export function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Verificar si la cookie de aceptación de cookies está presente
var cookieAccepted = getCookie('cookieAccepted');
console.log('cookieAccepted');
if (cookieAccepted) {
    // El usuario ha aceptado las cookies
    console.log('El usuario ha aceptado las cookies.');
} else {
    // El usuario aún no ha aceptado las cookies
    console.log('El usuario aún no ha aceptado las cookies.');
}
export function initializeCookieBanner() {
    // Verificar si ya se aceptaron las cookies utilizando sessionStorage o la cookie directamente
    if (sessionStorage.getItem("cookiesAccepted") || getCookie('cookieAccepted')) {
        document.getElementById("cookie-banner").classList.add("hidden");
    } else {
        // Cuando el DOM esté cargado
        document.addEventListener("DOMContentLoaded", function() {
            // Manejar clic en el botón de aceptar cookies
            document.getElementById("accept-cookies").addEventListener("click", function() {
                // Eliminar el banner de cookies
                document.getElementById("cookie-banner").classList.add("hidden");

                // Marcar que las cookies fueron aceptadas (almacenar en sessionStorage)
                sessionStorage.setItem("cookiesAccepted", "true");

                // Setear la cookie
                setCookie('cookieAccepted', 'true', 365);
            });
        });
    }
}

// Llamar a la función para iniciar el banner de cookies
initializeCookieBanner();
