<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tagfdfsg -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/main.css">

    <title><?=$app_config["app"]["name"]?></title>
</head>

<body class="bg-gray-200 p-4">

    <div class="flex">
        <!-- Sección 1 -->
        <div class="flex-1 p-4 m-2 mt-10 hidden md:flex flex-col">
            <p class="text-black text-7xl text-center">LA TEVA ORLA EN POCS PASOS</p>
            <p class="text-black text-xl text-center mt-10">No necessites instal·lar ni descarregar res i la pots fer des de qualsevol
                ordinador. I podràs descarregar una prova en PDF!</p>
        </div>





        <!-- Sección 2 -->

        <div class="flex-1  p-4 m-2">


            <div class="w-full max-w-xs m-auto">

                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="/login" method="post">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                            Iniciar sesión
                        </label>
                        <input
                            class="bg-gray-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="username" type="text" placeholder="Usuario">
                    </div>
                    <div class="mb-6">
                        <input
                            class="bg-gray-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" type="password" placeholder="Contraseña">
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            class="ml-auto inline-flex items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none"
                            type="submit">
                            Iniciar sessió
                        </button>

                    </div>
                </form>


                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-0" action="/register" method="post">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                            Crear nou compte
                        </label>
                        <input
                            class="bg-gray-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" type="email" placeholder="Correo electrónico">
                    </div>
                    <div class="mb-4">
                        <input
                            class="bg-gray-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" type="text" placeholder="Nombre">
                    </div>
                    <div class="mb-4">
                        <input
                            class="bg-gray-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="surname" type="text" placeholder="Apellido">
                    </div>
                    <div class="mb-4">
                        <input
                            class="bg-gray-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="birth_date" type="date">
                    </div>
                    <div class="mb-6">
                        <input
                            class="bg-gray-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" type="password" placeholder="Contraseña">
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            class="ml-auto inline-flex items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none"
                            type="submit">
                            Registrarse
                        </button>
                    </div>
                </form>










            </div>
        </div>
    </div>











    <div class="container mx-auto p-10">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <h1
                    class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-3xl lg:text-4xl dark:text-white">
                    Portada</h1>

                <a href="/privat"
                    class="focus:outline-none text-white bg-orange-400 hover:bg-orange-500 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 my-2">Accedeix
                    a la zona privada</a>

                <a href="/test"
                    class="focus:outline-none text-white bg-orange-400 hover:bg-orange-500 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 my-2">Accedeix
                    a la pagina de prova</a>

            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 mt-10">
            <div class="text-base">
                <p><?= $missatge  ?></p>
                <p id="missatge"></p>
            </div>
        </div>
    </div>
    <script src="/js/bundle.js"></script>
</body>

</html>