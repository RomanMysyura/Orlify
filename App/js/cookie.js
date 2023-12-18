// Funció per establir una galeta
// Funció per establir una galeta amb SameSite=None i Secure
export default function setCookie(name, value, days) {
    var expires = "";
    var sameSite = "; SameSite=None; Secure"; // Afegeix Secure si estàs utilitzant HTTPS

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }

    document.cookie = name + "=" + value + expires + sameSite + "; path=/";
}

// Funció per obtenir una galeta
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

// Funció per inicialitzar la barra de galetes
export function initializeCookieBanner() {
    // Verificar si ja s'han acceptat les galetes utilitzant sessionStorage o la galeta directament
    if (sessionStorage.getItem("cookiesAccepted") || getCookie('cookieAccepted')) {
        var cookieBannerElement = document.getElementById("cookie-banner");
        if (cookieBannerElement) {
            cookieBannerElement.classList.add("hidden");
        }
    } else {
        // Quan el DOM estigui carregat
        document.addEventListener("DOMContentLoaded", function () {
            var acceptCookiesButton = document.getElementById("accept-cookies");
            var cookieBannerElement = document.getElementById("cookie-banner");

            if (acceptCookiesButton && cookieBannerElement) {
                // Gestionar clic al botó d'acceptar galetes
                acceptCookiesButton.addEventListener("click", function () {
                    // Eliminar la barra de galetes
                    cookieBannerElement.classList.add("hidden");

                    // Marcar que les galetes han estat acceptades (emmagatzematge a sessionStorage)
                    sessionStorage.setItem("cookiesAccepted", "true");

                    // Establir la galeta
                    setCookie('cookieAccepted', 'true', 365);
                });
            }
        });
    }
}

// Encapsula la lògica d'inicialització en una funció autoexecutable
(function () {
    initializeCookieBanner();
})();
