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

export function initializeCookieBanner() {
    // Verificar si ya se aceptaron las cookies utilizando sessionStorage o la cookie directamente
    if (sessionStorage.getItem("cookiesAccepted") || getCookie('cookieAccepted')) {
        var cookieBannerElement = document.getElementById("cookie-banner");
        if (cookieBannerElement) {
            cookieBannerElement.classList.add("hidden");
        }
    } else {
        // Cuando el DOM esté cargado
        document.addEventListener("DOMContentLoaded", function () {
            var acceptCookiesButton = document.getElementById("accept-cookies");
            var cookieBannerElement = document.getElementById("cookie-banner");

            if (acceptCookiesButton && cookieBannerElement) {
                // Manejar clic en el botón de aceptar cookies
                acceptCookiesButton.addEventListener("click", function () {
                    // Eliminar el banner de cookies
                    cookieBannerElement.classList.add("hidden");

                    // Marcar que las cookies fueron aceptadas (almacenar en sessionStorage)
                    sessionStorage.setItem("cookiesAccepted", "true");

                    // Setear la cookie
                    setCookie('cookieAccepted', 'true', 365);
                });
            }
        });
    }
}

// Encapsula la lógica de inicialización en una función autoejecutable
(function () {
    initializeCookieBanner();
})();

