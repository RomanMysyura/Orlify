<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/main.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/paneldecontrol.js"></script>
    <title><?=$app_config["app"]["name"]?></title>
</head>

<body class="bg-gray-200">
    <?php include "navbar.php" ?>

    <div class="flex">
        <!-- Menú a la izquierda -->
        <div class="flex flex-col w-48">
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="editarUsuarioBtn">Editar Usuaris</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="crearUsuarioBtn">Afegir Usuari</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="editorlesBtn">Editar Orles</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="editphotoBtn">Editar Fotografies</a>
        </div>

        <!-- Textos a la derecha -->
        <div class="ml-0 w-full">
            <div class="editar_usuari">
                <table class=" bg-white border border-gray-300 w-full">
                    <!-- ... (resto de la tabla) ... -->
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Nombre</th>
                            <th class="py-2 px-4 border-b">Apellido</th>
                            <th class="py-2 px-4 border-b">Correo Electrónico</th>
                            <th class="py-2 px-4 border-b">Teléfono</th>
                            <th class="py-2 px-4 border-b">DNI</th>
                            <th class="py-2 px-4 border-b">Fecha de Nacimiento</th>
                            <th class="py-2 px-4 border-b">Rol</th>
                            <th class="py-2 px-4 border-b">Acciones</th> <!-- Nueva columna para el botón de editar -->
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?= $user['id'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $user['name'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $user['surname'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $user['email'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $user['phone'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $user['dni'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $user['birth_date'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $user['role'] ?></td>
                            <td class="py-2 px-4 border-b">
                                <button class="btn">Editar usuari</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>




            </div>

            <div class="crear_usuari ">

                <button id="crearUsuarioPrueba"
                    class="btn btn-outline mt-5 items-center justify-start h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-black rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                    Crear Usuari de Prova
                </button>

                <!-- Formulario -->
                <form class="bg-white shadow-md w-full max-w-md m-auto rounded px-8 pt-6 pb-8 mb-4" action="/register"
                    method="post">
                    <!-- Campos del formulario -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-md font-bold mb-4" for="username">
                            Crear nuevo usuario
                        </label>
                        <div class="mt-5">
                            <div class="relative">
                                <input id="mail" name="mail" type="text" placeholder="Correo electrónico"
                                    class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="username" name="username" type="text" placeholder="Nombre"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="surname" name="surname" type="text" placeholder="Apellidos"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <div class="mb-4 mt-5">
                        <label class="text-xs text-black top-4" for="birth_date">
                            Fecha de nacimiento
                            <input
                                class="bg-gray-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="birth_date" name="birth_date" type="date">
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="password" name="password" type="password" placeholder="Contraseña"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-10">

                        <button
                            class="btn btn-outline ml-auto inline-flex items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-black rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none"
                            type="submit">
                            Crear nou usuari
                        </button>
                    </div>
                </form>
            </div>


            <div class="editorles">
                <h1>Editar Orles</h1>
            </div>
            <div class="editphoto">
                <h1>Editar Photos</h1>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

    <script>
    $(document).ready(function() {
        $(".editorles, .editphoto, .crear_usuari").hide();

        $("#editarUsuarioBtn").click(function() {
            $(".editar_usuari, .crear_usuari, .editorles, .editphoto").hide();
            $("#editorlesBtn, #editphotoBtn, #crearUsuarioBtn").removeClass("bg-gray-400").addClass(
                "bg-white");

            $(".editar_usuari").show();

            $(this).removeClass("bg-white").addClass("bg-gray-400");
        });

        $("#crearUsuarioBtn").click(function() {
            $(".editar_usuari, .editorles, .editphoto").hide();
            $("#editarUsuarioBtn, #editphotoBtn, #editorlesBtn").removeClass("bg-gray-400").addClass(
                "bg-white");

            $(".crear_usuari").show();

            $(this).removeClass("bg-white").addClass("bg-gray-400");
        });

        $("#editorlesBtn").click(function() {
            $(".editar_usuari, .crear_usuari, .editorles, .editphoto").hide();
            $("#editarUsuarioBtn, #editphotoBtn,  #crearUsuarioBtn").removeClass("bg-gray-400")
                .addClass("bg-white");

            $(".editorles").show();

            $(this).removeClass("bg-white").addClass("bg-gray-400");
        });

        $("#editphotoBtn").click(function() {
            $(".editar_usuari, .crear_usuari, .editorles, .editphoto").hide();
            $("#editarUsuarioBtn, #editorlesBtn,  #crearUsuarioBtn").removeClass("bg-gray-400")
                .addClass("bg-white");

            $(".editphoto").show();

            $(this).removeClass("bg-white").addClass("bg-gray-400");
        });
    });

    document.getElementById('crearUsuarioPrueba').addEventListener('click', function() {
        fetch('https://randomuser.me/api/')
            .then(response => response.json())
            .then(data => {
                document.getElementById('mail').value = data.results[0].email;
                document.getElementById('username').value = data.results[0].name.first;
                document.getElementById('surname').value = data.results[0].name.last;
                document.getElementById('birth_date').value = data.results[0].dob.date.substring(0, 10);
                document.getElementById('password').value = 'testing10';
            })
            .catch(error => console.error('Error:', error));
    });
    </script>
</body>

</html>