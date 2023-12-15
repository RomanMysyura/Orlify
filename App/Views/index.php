<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/main.css">
    <title><?= $app_config["app"]["name"] ?></title>
    <link rel="manifest" href="/manifest.json">

</head>
<!-- Contenedor del banner de cookies -->
<div id="cookie-banner" class="fixed bottom-0 w-full bg-gray-800 p-4 text-center shadow-md opacity-100 z-50">
    <p class="text-sm text-white">
        Utilitzem cookies per millorar la teva experiència al lloc. En continuar, acceptes l'ús de galetes.
    </p>
    <button id="accept-cookies" class="mt-2 bg-black hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Aceptar
    </button>
</div>


<body class="bg-gray-300 ">
    <?php include "navbar.php" ?>
 
    <div style="overflow: hidden;">
        <svg id="wave-path" preserveAspectRatio="none" viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg"
            style="fill: #ffffff; width: 100%; height: 60px;">

            <path
                d="M0 0v46.29c47.79 22.2 103.59 32.17 158 28 70.36-5.37 136.33-33.31 206.8-37.5 73.84-4.36 147.54 16.88 218.2 35.26 69.27 18 138.3 24.88 209.4 13.08 36.15-6 69.85-17.84 104.45-29.34C989.49 25 1113-14.29 1200 52.47V0z"
                opacity=".25" />
            <path
                d="M0 0v15.81c13 21.11 27.64 41.05 47.69 56.24C99.41 111.27 165 111 224.58 91.58c31.15-10.15 60.09-26.07 89.67-39.8 40.92-19 84.73-46 130.83-49.67 36.26-2.85 70.9 9.42 98.6 31.56 31.77 25.39 62.32 62 103.63 73 40.44 10.79 81.35-6.69 119.13-24.28s75.16-39 116.92-43.05c59.73-5.85 113.28 22.88 168.9 38.84 30.2 8.66 59 6.17 87.09-7.5 22.43-10.89 48-26.93 60.65-49.24V0z"
                opacity=".5" />
            <path
                d="M0 0v5.63C149.93 59 314.09 71.32 475.83 42.57c43-7.64 84.23-20.12 127.61-26.46 59-8.63 112.48 12.24 165.56 35.4C827.93 77.22 886 95.24 951.2 90c86.53-7 172.46-45.71 248.8-84.81V0z" />
        </svg>
    </div>



    <div class="flex">
        <div class="w-full md:w-1/2 lg:1/2 md:flex md:flex-col hidden">
            <div class="flex-1 p-4 m-9 mt-16 hidden md:flex flex-col ">
                <p class="text-7xl text-center font-bold">
                    <span class="bg-gradient-to-r text-black bg-clip-text animate-fadeInGradient">LA TEVA ORLA EN POCS
                        PASOS</span>
                </p>
                <div id="slider" x-data="{}" x-init="$nextTick(() => {
                let ul = $refs.logos;
                ul.insertAdjacentHTML('afterend', ul.outerHTML);
                ul.nextSibling.setAttribute('aria-hidden', 'true');
            })" class="slide w-full inline-flex flex-nowrap overflow-hidden [mask-image:_linear-gradient(to_right,transparent_0,_black_128px,_black_calc(100%-128px),transparent_100%)]">
                    <ul x-ref="logos"
                        class="flex items-center justify-center md:justify-start [&_li]:mx-4 mt-4 [&_img]:max-w-none animate-infinite-scroll">
                        <li class="mx-4 mt-4">
                            <img class="h-24 slide" src="/img/index/img1.png" alt="Logo 1">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24 slide" src="/img/index/img2.png" alt="Logo 2">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24 slide" src="/img/index/img3.png" alt="Logo 3">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24 slide" src="/img/index/img4.png" alt="Logo 4">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24 slide" src="/img/index/img5.png" alt="Logo 5">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24 slide" src="/img/index/img6.png" alt="Logo 6">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24 slide" src="/img/index/img7.png" alt="Logo 7">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24 slide" src="/img/index/img8.png" alt="Logo 8">
                        </li>
                    </ul>

                    <ul x-ref="logos"
                        class="flex items-center justify-center md:justify-start [&_li]:mx-4 mt-4 [&_img]:max-w-none animate-infinite-scroll"
                        aria-hidden="true">
                        <li class="mx-4 mt-4">
                            <img class="h-24" src="/img/index/img1.png" alt="Logo 1">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24" src="/img/index/img2.png" alt="Logo 2">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24" src="/img/index/img3.png" alt="Logo 3">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24" src="/img/index/img4.png" alt="Logo 4">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24" src="/img/index/img5.png" alt="Logo 5">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24" src="/img/index/img6.png" alt="Logo 6">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24" src="/img/index/img7.png" alt="Logo 7">
                        </li>
                        <li class="mx-4 mt-4">
                            <img class="h-24" src="/img/index/img8.png" alt="Logo 8">
                        </li>
                    </ul>
                </div>
                <p class="text-xl text-center mt-10 text-black">No necessites instal·lar ni descarregar res i la
                    pots fer
                    des de qualsevol ordinador. I podràs descarregar una prova en PDF!</p>
            </div>




            <div class="mockup-phone mobileborders animate-box">
                <div class="camera"></div>
                <div class="display">
                    <div class="artboard artboard-demo phone-1">
                        <div class="video-container">
                            <video width="700" height="450" loop autoplay muted style="margin-top: -37px;">
                                <source src="/img/phoneee3.mp4" type="video/mp4">
                                Tu navegador no soporta el elemento de video.
                            </video>
                        </div>
                    </div>
                </div>
            </div>



        </div>



        <div class="w-full w-1/2">
            <div class="flex-1  p-4 m-2">
                <div class="w-full max-w-md m-auto">
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
                                <input id="pass" name="password" title="password" type="password"
                                    placeholder="Contrasenya"
                                    class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-5">
                            <a href="/recuperarpass" class="text-sky-800">Has oblidat la contrasenya?</a>
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
                    <form class="bg-white shadow-md w-full max-w-md m-auto rounded px-8 pt-6 pb-8 mb-4"
                        action="/register" method="post">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-md font-bold mb-4" for="username">
                                Crear nou compte
                            </label>
                            <div class="mt-5">
                                <div class="relative">
                                    <input id="mail" title="mail" name="mail" type="text"
                                        placeholder="Correu electronic"
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
                            <input id="password" title="password" name="password" type="password"
                                placeholder="Contrasenya"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />

                            <!-- Botón para mostrar información al pasar el ratón -->
                            <button id="infoButton" type="button" title="Password info"
                                class="absolute inset-y-0 right-0 px-3 flex items-center bg-gray-200 hover:bg-gray-300 rounded-r-md mb-2">
                                <svg class="w-6 h-6 bg-gray-200 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="#6b7280" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7.529 7.988a2.502 2.502 0 0 1 5 .191A2.441 2.441 0 0 1 10 10.582V12m-.01 3.008H10M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>

                            <!-- Contenedor de información -->
                            <div id="infoContainer"
                                class="absolute z-10 invisible bg-white border border-gray-200 rounded-lg shadow-sm p-4 right-0">
                                <p>Entre 6 i 13 lletres</p>
                                <p>1 caracter especial</p>
                                <p>Almenys 1 lletra i 1 número</p>
                            </div>
                        </div>
                        <div id="mss"></div>




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
    </div>


    <?php include "footer.php" ?>
    <script src="/js/bundle.js" defer></script>
</body>

</html>