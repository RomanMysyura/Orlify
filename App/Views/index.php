<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/main.css">
    <title>
        <?= $app_config["app"]["name"] ?>
    </title>

</head>


<!-- Contenedor del banner de cookies -->
<div id="cookie-banner" class="fixed bottom-0 left-0 w-full bg-gray-200 p-4 text-center shadow-md">
    <p class="text-sm text-gray-700">
        Utilizamos cookies para mejorar tu experiencia en el sitio. Al continuar, aceptas el uso de cookies.
    </p>
    <button id="accept-cookies" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        Aceptar
    </button>
</div>

<script>
    // Function to set a cookie
// Function to set a cookie with SameSite=None and Secure
function setCookie(name, value, days) {
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

    function getCookie(name) {
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

if (cookieAccepted) {
    // El usuario ha aceptado las cookies
    console.log('El usuario ha aceptado las cookies.');
} else {
    // El usuario aún no ha aceptado las cookies
    console.log('El usuario aún no ha aceptado las cookies.');
}
    // Cuando el DOM esté cargado
    document.addEventListener("DOMContentLoaded", function() {
        // Verificar si ya se aceptaron las cookies utilizando sessionStorage
        if (sessionStorage.getItem("cookiesAccepted") === null) {
            // Mostrar el banner de cookies solo si la cookie no está presente
            if (!getCookie('cookieAccepted')) {
                document.getElementById("cookie-banner").classList.remove("hidden");
            }
        }

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
</script>



<body class="bg-gray-200 ">
    <?php include "navbar.php" ?>

    <div class="flex">
        <div class="flex-1 p-4 m-9 mt-16 hidden md:flex flex-col ">
            <p class="text-7xl text-center font-bold">
                <span class="bg-gradient-to-r text-black bg-clip-text animate-fadeInGradient">LA TEVA ORLA EN POCS
                    PASOS</span>
            </p>
            <div class="w-full max-w-xl mt-5 mx-auto overflow-hidden">
                <div id="slider"
                    class="carousel carousel-end rounded-box flex transition-transform duration-500 ease-in-out">
                    <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img1.png" alt="Imagen 1"
                            class="w-full h-full object-cover transition-opacity duration-500 "></div>
                    <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img2.png" alt="Imagen 2"
                            class="w-full h-full object-cover transition-opacity duration-500 "></div>
                    <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img3.png" alt="Imagen 3"
                            class="w-full h-full object-cover transition-opacity duration-500 "></div>
                    <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img4.png" alt="Imagen 4"
                            class="w-full h-full object-cover transition-opacity duration-500 "></div>
                    <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img5.png" alt="Imagen 5"
                            class="w-full h-full object-cover transition-opacity duration-500 "></div>
                    <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img6.png" alt="Imagen 6"
                            class="w-full h-full object-cover transition-opacity duration-500 "></div>
                    <!-- <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img7.png" alt="Imagen 7" class="w-full h-full object-cover transition-opacity duration-500 "></div>
                    <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img8.png" alt="Imagen 8" class="w-full h-full object-cover transition-opacity duration-500 "></div>
                    <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img9.png" alt="Imagen 9" class="w-full h-full object-cover transition-opacity duration-500 "></div>
                    <div class="w-full w-24 h-24 slide m-2"><img src="../img/index/img10.png" alt="Imagen 10" class="w-full h-full object-cover transition-opacity duration-500 "></div> -->

                </div>
            </div>
            <p class="text-xl text-center mt-10 text-black">No necessites instal·lar ni descarregar res i la pots fer
                des de qualsevol ordinador. I podràs descarregar una prova en PDF!</p>
        </div>
        <div class="flex-1  p-4 m-2">
            <div class="w-full max-w-md  m-auto">
                <?php if (isset($error_message_login)): ?>
                <div role="alert" class="alert alert-error mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>
                        <?php echo $error_message_login; ?>
                    </span>
                </div>
                <?php endif; ?>





                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 " action="/login" method="post">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-md font-bold mb-4" for="username">
                            Iniciar sessió
                        </label>
                        <div class="mt-5">
                            <div class="relative">
                                <input id="email" title="email" name="email" type="email"
                                    placeholder="Correu electronic"
                                    class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="pass" name="password" title="password" type="password" placeholder="Contrasenya"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-5">
                        <a href="/recuperarpass" class="text-blue-500">Has oblidat la contrasenya?</a>
                    </p>
                    <div class="flex items-center justify-between mt-10">
                        <button
                            class=" btn btn-outline ml-auto inline-flex items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none"
                            type="submit">
                            Iniciar sessió
                        </button>
                    </div>
                </form>


                <?php if (isset($error_message_register)): ?>
                <div role="alert" class="alert alert-success mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>
                        <?php echo $error_message_register; ?>
                    </span>
                </div>
                <?php endif; ?>
                <form class="bg-white shadow-md w-full max-w-md m-auto rounded px-8 pt-6 pb-8 mb-4" action="/register"
                    method="post">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-md font-bold mb-4" for="username">
                            Crear nou compte
                        </label>
                        <div class="mt-5">
                            <div class="relative">
                                <input id="mail" title="mail" name="mail" type="text" placeholder="Correu electronic"
                                    class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="username" title="username" name="username" type="text" placeholder="Nom"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="surname" title="surname" name="surname" type="text" placeholder="Cognoms"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <div class="mb-4 mt-5">
                        <label class="text-xs text-black top-4" for="birth_date">
                            Data de naixement
                            <input title="data"
                                class="bg-gray-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="birth_date" name="birth_date" type="date">
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="phone" name="phone" title="phone" type="text" placeholder="Telèfon"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="relative">
                            <input id="dni" name="dni" title="dni" type="text" placeholder="DNI"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <div class="mt-5 relative">
                        <input id="password" title="password" name="password" type="password" placeholder="Contrasenya"
                            class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />

                        <!-- Botón para mostrar información al pasar el ratón -->
                        <button id="infoButton" type="button"
                            class="absolute inset-y-0 right-0 px-3 flex items-center bg-gray-200 hover:bg-gray-300 rounded-r-md mb-2">
                            <svg class="w-6 h-6 bg-gray-200 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="#6b7280" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>

                        <!-- Contenedor de información -->
                        <div id="infoContainer"
                            class="absolute z-10 invisible bg-white border border-gray-200 rounded-lg shadow-sm p-4 right-0">
                            <p>Entre 6 y 13 letras</p>
                            <p>1 caracter especial</p>
                            <p>Al menos 1 letra y 1 número</p>
                        </div>
                    </div>
                    <div id="mss"></div>
                    <script>
                    // Agregar evento al pasar el ratón sobre el botón
                    document.getElementById('infoButton').addEventListener('mouseover', function() {
                        // Mostrar el contenedor de información
                        document.getElementById('infoContainer').classList.remove('invisible');
                    });

                    // Agregar evento al quitar el ratón del botón
                    document.getElementById('infoButton').addEventListener('mouseout', function() {
                        // Ocultar el contenedor de información
                        document.getElementById('infoContainer').classList.add('invisible');
                    });
                    </script>



                    <!-- Otros campos del formulario ... -->

                    <div class="mt-5">
                        <label class="block text-gray-700 text-md font-bold mb-4" for="group">
                            Selecciona el teu curs
                        </label>
                        <select id="group" name="group"
                            class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit">
                            <option value="1">1 SMX</option>
                            <option value="2">2 SMX</option>
                            <option value="3">1 DAW</option>
                            <option value="4">2 DAW</option>
                            <option value="5">1 ESO</option>
                            <option value="6">2 ESO</option>
                            <option value="7">3 ESO</option>
                            <option value="8">4 ESO</option>
                            <option value="9">1 BAT</option>
                            <option value="10">2 BAT</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between mt-10">
                        <button id="btnEnviar"
                            class="btn btn-outline ml-auto inline-flex items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-black rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none"
                            type="submit">
                            Registrarse
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
    const slider = document.getElementById('slider');

    // Configuración del slider
    const intervaloTiempo = 2000; // Intervalo de tiempo en milisegundos (2 segundos en este caso)

    function moverSlider() {
        const anchoSlide = document.querySelector('.slide').offsetWidth;
        slider.style.transition = 'transform 0.8s ease-in-out';
        slider.style.transform = `translateX(-${anchoSlide}px)`;

        // Cuando la animación de transición ha terminado, mueve el primer slide al final
        setTimeout(() => {
            const primerSlide = slider.firstElementChild;
            slider.appendChild(primerSlide);
            slider.style.transition = 'none';
            slider.style.transform = 'translateX(0)';
        }, 800); // Ajusta el tiempo de espera a la duración de la transición
    }

    // Inicia el slider automáticamente
    setInterval(moverSlider, intervaloTiempo);
    </script>
    <?php include "footer.php" ?>
    <script src="/js/bundle.js"></script>
</body>

</html>