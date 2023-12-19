<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <title>Perfil</title>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <!-- Centrar el título -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Nova Contrasenya</h2>

        <form class="space-y-4" action="/newpass" method="post">
            <div class="mt-5">
                <div class="relative">
                    <input id="email" title="email" name="email" type="text"
                        placeholder="Correu electronic"
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

            <div>
                <button type="submit" id="btnEnviar"
                    class="w-full btn btn-outline ml-auto inline-flex items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-black rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                    Guardar Contrasenya
                </button>
            </div>
        </form>
    </div>
</body>
<script src="/js/bundle.js" defer></script>
</html>
