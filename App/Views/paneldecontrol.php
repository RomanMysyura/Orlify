<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/main.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/paneldecontrol.js"></script>
    <title>
        <?= $app_config["app"]["name"] ?>
    </title>
</head>

<body class="bg-gray-200">
    <?php include "navbar.php" ?>

    <div class="flex">
        <div class="flex flex-col w-48">
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="editarUsuarioBtn">Editar Usuaris</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="crearUsuarioBtn">Afegir Usuari</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="editorlesBtn">Editar Orles</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="editphotoBtn">Editar Fotografies</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="notificationsBtn">Notificacions d'error</a>
        </div>

        <div class="ml-0 w-full">
            <div class="editar_usuari">
                <table class=" bg-white border border-gray-300 w-full">
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
                            <td class="py-2 px-4 border-b">
                                <?= $user['id'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $user['name'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $user['surname'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $user['email'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $user['phone'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $user['dni'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $user['birth_date'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $user['role'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <button class="btn" onclick="mostrarModalEditarUsuario(<?= $user['id'] ?>)">Editar
                                    usuari</button>
                            </td>
                            <td>
                                <button>
                                    <a href="/deleteUser?id=<?= $user['id']; ?>"
                                        class="bg-red-500 text-white py-2 px-4 rounded"
                                        onclick="return confirm('Estas segur que vols eliminar aquest usuari?')">
                                        Eliminar <i class="fa-solid fa-trash"></i>
                                    </a>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="modalEditarUsuario" class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 hidden">
                    <div class="flex justify-center items-center h-full">
                        <div class="bg-white p-8 rounded-lg shadow-md w-96">
                            <form id="editarUsuarioForm" action="/Idpanel" method="get"
                                class="p-4 bg-white rounded-md shadow-md">
                                <!-- Campo oculto para almacenar la ID del usuario -->
                                <input type="hidden" id="userId" name="userId" value="">
                                <!-- Otros campos del formulario -->

                                <td class="py-2 px-4 border-b">
                                    <button type="submit" class="btn">Editar usuari</button>
                                </td>
                            </form>
                            <button id="cerrarModal" class="btn bg-gray-400 hover:bg-gray-500"
                                onclick="cerrarModalEditarUsuario()">Cerrar</button>
                        </div>
                    </div>
                </div>


            </div>

            <div class="crear_usuari ">

                <form class="bg-white shadow-md w-full max-w-xl mt-2 m-auto rounded px-8 pt-6 pb-8 mb-4"
                    action="/randomuser" method="post">
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
                            <input id="role" name="role" type="text" placeholder="Rol" autocomplete="username"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />

                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="password" name="password" type="password" placeholder="Contraseña"
                                autocomplete="current-password"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />

                        </div>
                    </div>
                    <div class="mt-5 flex items-center justify-center">
                        <button
                            class="btn btn-outline inline-flex items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-black rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none"
                            type="submit">
                            Crear nou usuari
                        </button>
                    </div>
                </form>
                <div class="flex justify-center mt-2">
                    <button id="crearUsuarioPrueba" type="button"
                        class="btn btn-outline items-center justify-center  h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-black rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                        Crear Usuari de Prova
                    </button>
                </div>
                <form id="crearUsuariosForm"
                    class="bg-white shadow-md w-full max-w-xl mt-5 m-auto rounded px-8 pt-6 pb-8 mb-4">
                    <label class="block text-black text-md font-bold mb-4" for="numUsuarios">
                        Crear x número d'usuaris
                    </label>
                    <input id="numUsuarios" name="numUsuarios" type="text" placeholder="Número d'usuaris"
                        class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                    <div class="mt-5 flex items-center justify-center">
                        <button id="crearUsuariosBtn"
                            class="btn btn-outline inline-flex mt-2 items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-black rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none"
                            type="submit">
                            Crear
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

            <div class="notifications">
                <table class=" bg-white border border-gray-300 w-full">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Id Usuari</th>
                            <th class="py-2 px-4 border-b">Email</th>
                            <th class="py-2 px-4 border-b">Descripció</th>
                            <th class="py-2 px-4 border-b">Estat</th>
                            <th class="py-2 px-4 border-b">Data</th>
                            <th class="py-2 px-4 border-b">Acciones</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($errors as $error): ?>
                        <input type="hidden" name="id" value="<?= $error['error_id'] ?>">
                        <tr>
                            <td class="py-2 px-4 border-b">
                                <?= $error['user_id'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $error['user_email'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $error['error_description'] ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= $error['error_date'] ?>
                            </td>
                            <form method="POST" action="/uploaderror">
                                <input type="hidden" name="id" value="<?= $error['error_id'] ?>">
                                <td class="py-2 px-4 border-b">
                                    <select name="error_status" class="select select-bordered w-full max-w-xs">
                                        <?php foreach (['Pending', 'Resuelta', 'Rechazada'] as $status): ?>
                                        <option <?= ($error['error_status'] === $status) ? 'selected' : '' ?>>
                                            <?= $status ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">
                                        Aceptar
                                    </button>
                                </td>
                            </form>

                            <td class="py-2 px-4 border-b">
                                <button>
                                    <a href="/deleteerror?id=<?= $error['error_id']; ?>"
                                        class="bg-red-500 text-white py-2 px-4 rounded">
                                        Eliminar
                                    </a>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

    <script src="../js/paneldecontrol.js"></script>


</body>

</html>