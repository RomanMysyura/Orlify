<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/main.css">
    <link href="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/newtonsCradle.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="../js/paneldecontrol.js"></script>
    <title>
        <?= $app_config["app"]["name"] ?>
    </title>
</head>

<body class="bg-gray-200">
    <?php include "navbar.php" ?>

    <div class="flex">
        <div class="flex flex-col w-52">
            <a href="#" class="p-4 bg-white hover:bg-gray-200" id="editarUsuarioBtn">Editar Usuaris</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-200" id="crearUsuarioBtn">Afegir Usuari</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-200" id="editorlesBtn">Editar Orles</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-200" id="editarGrupsBtn">Editar Grups</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-200" id="notificationsBtn">Notificacions d'error</a>

        </div>


        <div class="ml-0 w-full">
            <div class="editar_usuari">
                <div class='flex items-center justify-center '>
                    <div class="flex rounded-full bg-white px-2 mt-2 mb-2 w-full max-w-md">

                        <input type="text" id="searchInput"
                            class="w-full  flex bg-transparent pl-5 text-black outline-0 border-0" title="Search"
                            placeholder="Buscar usuaris..." />


                        <button type="submit" class="relative p-2 bg-white rounded-full" title="SearchButton">
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                                <g id="SVGRepo_bgCarrier" stroke-width="0" />

                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M14.9536 14.9458L21 21M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                        stroke="#999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <!-- a -->
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra bg-white border border-gray-300 w-full">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-gray-700">ID</th>
                                <th class="py-2 px-4 border-b text-gray-700">Nom</th>
                                <th class="py-2 px-4 border-b text-gray-700">Cognom</th>
                                <th class="py-2 px-4 border-b text-gray-700">Correu electronic</th>
                                <th class="py-2 px-4 border-b text-gray-700">Teléfon</th>
                                <th class="py-2 px-4 border-b text-gray-700">DNI</th>
                                <th class="py-2 px-4 border-b text-gray-700">Data de naixement</th>
                                <th class="py-2 px-4 border-b text-gray-700">Grup</th>
                                <th class="py-2 px-4 border-b text-gray-700">Rol</th>
                                <th class="py-2 px-4 border-b text-gray-700">Accions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr class="userRow hover:bg-gray-200 ">
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
                                    <?php if (isset($user['groups']) && is_array($user['groups'])): ?>
                                    <?= implode(', ', $user['groups']); ?>
                                    <?php elseif (isset($user['groups'])): ?>
                                    <?= $user['groups']; ?>
                                    <?php else: ?>
                                    Sin grupo asignado
                                    <?php endif; ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <?= $user['role'] ?>
                                </td>
                                <td class="py-2 px-2 border-b">
                                    <button class="btn bg-white w-16"
                                        onclick="toggleCollapse2('collapse<?= $user['id'] ?>')">
                                        <img src="../img/foto3.png" alt="expand"
                                            class="w-6 h-6 object-cover rounded-lg">
                                    </button>
                                    <button class="btn bg-white w-16"
                                        onclick="openEditModal('<?= $user['id'] ?>', '<?= $user['name'] ?>', '<?= $user['surname'] ?>', '<?= $user['email'] ?>', '<?= $user['phone'] ?>', '<?= $user['dni'] ?>', '<?= $user['birth_date'] ?>', '<?= $user['role'] ?>', '<?= $user['groups'] ?>')">
                                        <img src="../img/editar.png" alt="edit" class="w-6 h-6 object-cover rounded-lg">
                                    </button>
                                    <button class="btn bg-white w-16">
                                        <a href="/deleteUser?id=<?= $user['id']; ?>"
                                            onclick="return confirm('Estas segur que vols eliminar aquest usuari?')">
                                            <img src="../img/eliminar2.png" alt="delete"
                                                class="w-6 h-6 object-cover rounded-lg">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </button>
                                </td>
                            <tr id="collapse<?= $user['id'] ?>" class="hidden">
                                <td colspan="10">
                                    <div class="collapse bg-white transition ease-in-out duration-300 overflow-x-auto">
                                        <div
                                            class="collapse-title text-md font-medium flex justify-center items-center">
                                            <?php if (!empty($user['photos'])): ?>
                                            <?php foreach ($user['photos'] as $photo): ?>
                                            <div class="flex-shrink-0 items-center justify-center mx-5">
                                                <img src="<?= $photo['url'] ?>" alt="<?= $photo['name'] ?>"
                                                    class="w-32 h-32 object-cover rounded-lg">
                                                <div class="flex flex-col items-center">
                                                    <p class="mt-2"><?= $photo['name'] ?></p>
                                                    <button class="btn btn-outline btn-xs mt-2"><a
                                                            href="/eliminarPhoto?id=<?= $photo['id']; ?>">Eliminar</a></button>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <p>Encara no hi ha fotografies.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <dialog id="edit_modal" class="modal">
                    <div class="modal-box">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                                onclick="closeEditModal()">✕
                            </button>
                        </form>
                        <div class="text-center">
                            <h3 class="font-bold text-lg">Editar usuari</h3>
                        </div>
                        <div id="user_details">
                        </div>

                    </div>
                </dialog>

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
                                <input id="mail" name="mail" type="text" title="mail" placeholder="Correo electrónico"
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
                            <input id="surname" name="surname" title="surname" type="text" placeholder="Apellidos"
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
                            <input id="role" name="role" type="text" placeholder="Rol" title="rol"
                                autocomplete="username"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />

                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="password" name="password" type="password" title="password"
                                placeholder="Contraseña" autocomplete="current-password"
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
                <div id="loader"
                    class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-gray-200 bg-opacity-75 hidden">
                    <l-newtons-cradle size="78" speed="1.4" color="black"></l-newtons-cradle>
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
                            type="button">
                            Crear
                        </button>
                    </div>
                </form>
            </div>


            <div class="editorles">

                <table class="bg-white border border-gray-300 w-full overflow-x-auto">
                    <table class="bg-white border border-gray-300 w-full table table-zebra">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b  text-gray-700">ID</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Estat</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Enllaç</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Nom</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Grup</th>
                                <th class="py-2 px-4 border-b  text-gray-700">PDF</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Accions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($orles as $orla): ?>
                            <tr class="userRow hover:bg-gray-200 group">
                                <td class="py-2 px-4 border-b">
                                    <?= $orla['orla_id'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <?= $orla['status'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="<?= $orla['url'] ?>" target="_blank"><?= $orla['url'] ?></a>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <?= $orla['name_orla'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <?= $orla['group_name'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <button class="btn bg-white w-16">
                                        <a href="/downloadpdf?id=<?= $orla['orla_id']; ?>">
                                            <img src="../img/descargar.png" alt="pdf"
                                                class="w-6 h-6 object-cover rounded-lg">
                                        </a>
                                    </button>
                                </td>
                                <td class="py-2 px-4 border-b items-center justify-center">
                                    <button class="btn bg-white w-16"
                                        onclick="toggleCollapse('collapse<?= $orla['orla_id'] ?>')">
                                        <img src="../img/foto3.png" alt="expand"
                                            class="w-6 h-6 object-cover rounded-lg">
                                    </button>
                                    <button class="btn bg-white w-16"
                                        onclick="openEditModal2('<?= $orla['orla_id'] ?>', '<?= $orla['name_orla'] ?>', '<?= $orla['status']?>', '<?= $orla['url']?>', '<?= $orla['group_id']?>', '<?= $orla['group_name']?>')">
                                        <img src="../img/editar.png" alt="edit" class="w-6 h-6 object-cover rounded-lg">
                                    </button>
                                    <button class="btn bg-white w-16">
                                        <a href="/eliminarOrlaPanel?id=<?= $orla['orla_id']; ?>" class=""
                                            onclick="return confirm('Estas segur que vols eliminar aquesta orla?')">
                                            <img src="../img/eliminar2.png" alt="delete"
                                                class="w-6 h-6 object-cover rounded-lg">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </button>

                                </td>
                            </tr>
                            <!-- Detalles colapsables -->
                            <tr id="collapse<?= $orla['orla_id'] ?>" class="hidden">
                                <td colspan="8">
                                    <div class="collapse bg-white transition ease-in-out duration-300 overflow-x-auto">
                                        <div
                                            class="collapse-title text-md font-medium flex justify-center items-center">
                                            <?php foreach ($orla['photos'] as $photo): ?>
                                            <div class="flex-shrink-0 items-center justify-center mx-5">
                                                <img src="<?= $photo['url'] ?>" alt="<?= $photo['name'] ?>"
                                                    class="w-32 h-32 object-cover rounded-lg">
                                                <div class="flex flex-col items-center">
                                                    <!-- Added div for vertical centering -->
                                                    <p class="mt-2"><?= $photo['name'] ?></p>
                                                    <!-- Added margin-top for spacing -->
                                                    <button class="btn btn-outline btn-xs mt-2"><a
                                                            href="/eliminarPhoto?id=<?= $photo['photo_id']; ?>">Eliminar</a></button>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <dialog id="edit_modal2" class="modal">
                        <div class="modal-box">
                            <form method="dialog">
                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                                    onclick="closeEditModal2()">✕
                                </button>
                            </form>
                            <div class="text-center">
                                <h3 class="font-bold text-lg">Editar orla</h3>
                            </div>
                            <div id="user_details2">
                            </div>
                        </div>
                    </dialog>
                </table>
            </div>
            <div class="editar_grups">
                <div class="flex justify-end items-center mb-4 mt-5">
                    <button id="crearGrupBtn" type="button" onclick="openEditModal3()"
                        class="btn btn-outline items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-black rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                        + Afegir Grup
                    </button>
                    <!-- Agregamos un espacio entre el botón y el borde derecho del contenedor -->
                    <div class="w-16"></div>
                </div>
                <div class="overflow-x-auto bg-white border border-gray-300 w-full mx-auto">
                    <table class="table table-zebra bg-white border border-gray-300 w-full ">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left text-gray-700 text-lg">Nom</th>
                                <th class="py-2 px-4 border-b text-right text-gray-700 text-lg">ID</th>
                                <th class="py-2 px-4 border-b text-right text-gray-700 text-lg mx-10">Eliminar</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($grups as $grup): ?>
                            <tr class="userRow group">
                                <td class="py-2 px-4 border-b">
                                    <?= $grup['name'] ?>
                                </td>
                                <td class="py-2 px-4 border-b text-right">
                                    <?= $grup['id'] ?>
                                </td>
                                <td class="py-2 px-4 border-b text-right w-32">
                                    <div class="flex items-center justify-end">
                                        <button class="btn bg-white w-16">
                                            <a href="/DeleteGrup?id=<?= $grup['id']; ?>" class=""
                                                onclick="return confirm('Estas segur que vols eliminar aquest grup?')">
                                                <img src="../img/eliminar2.png" alt="delete"
                                                    class="w-6 h-6 object-cover rounded-lg">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                    <dialog id="edit_modal3" class="modal">
                        <div class="modal-box">
                            <form method="dialog">
                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                                    onclick="closeEditModal3()">✕
                                </button>
                            </form>
                            <div class="text-center">
                                <h3 class="font-bold text-lg">Crear Grup</h3>
                            </div>
                            <div id="user_details3">
                            </div>
                        </div>
                    </dialog>
                </div>
            </div>


            <div class="notifications">

                <div class="overflow-x-auto bg-white">
                    <table class="table table-zebra bg-white border border-gray-300 w-full">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b  text-gray-700">Id </th>
                                <th class="py-2 px-4 border-b  text-gray-700">Id Usuari</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Email</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Descripció</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Data</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Estat</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Actualitzar</th>
                                <th class="py-2 px-4 border-b  text-gray-700">Acciones</th>

                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            <?php foreach ($errors as $error): ?>
                            <input type="hidden" name="id" value="<?= $error['error_id'] ?>">
                            <tr class="userRow hover:bg-gray-200">
                                <td class=" py-2 px-4 border-b">
                                    <?= $error['error_id'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <?= $error['user_id'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <?= $error['user_email'] ?>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <div class="truncate max-w-xs overflow-hidden">
                                        <?= $error['error_description'] ?>
                                    </div>
                                    <?php if (strlen($error['error_description']) > 30): ?>
                                    <div class="description hidden ">
                                        <?= $error['error_description'] ?>
                                    </div>
                                    <button class="text-blue-500 " onclick="toggleDescription(this)">
                                        Mostrar más
                                    </button>
                                    <?php endif; ?>
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
                                        <button type="submit" class="btn bg-white w-16">
                                            <img src="../img/actualizar.png" alt="update"
                                                class="w-6 h-6 object-cover rounded-lg">
                                        </button>
                                    </td>
                                </form>

                                <td class="py-2 px-4 border-b">
                                    <button class="btn bg-white w-16">
                                        <a href="/deleteerror?id=<?= $error['error_id']; ?>" class="">
                                            <img src="../img/eliminar2.png" alt="delete"
                                                class="w-6 h-6 object-cover rounded-lg">
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
    </div>

    <?php include "footer.php" ?>

    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/newtonsCradle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/paneldecontrol.js"></script>


</body>

</html>