<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">

    <title>Document</title>
</head>

<body>
    <?php include "navbar.php" ?>
    <div class="ml-0 w-full">
        <div class="editar_usuari">

            <div class='max-w-md mx-auto mb-5'>
                <div
                    class="relative flex items-center w-full h-12 rounded-lg focus-within:shadow-lg bg-white overflow-hidden">
                    <div class="grid place-items-center h-full w-12 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <input class="peer h-full w-full outline-none text-sm text-gray-700 pr-2" title="search" type="text"
                        id="searchInput" placeholder="Buscar por nombre, correo, etc." />
                </div>
            </div>

        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th class="font-bold text-lg">Email</th>
                    <th class="font-bold text-lg">Nom, Curs</th>
                    <th class="font-bold text-lg">Fecha de naixement</th>
                    <th class="font-bold text-lg">Numero de telefon</th>
                    <th class="font-bold text-lg">Ubicació de la foto</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                <?php foreach ($alumnes as $alumne): ?>
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div class="mask mask-squircle w-12 h-12">
                                    <img src=<?= $alumne['photo_url'] ?> alt="Avatar Tailwind CSS Component" />
                                </div>
                            </div>
                            <div>
                                <div class="text-lg font-bold"><?= $alumne['user_email'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="text-lg">
                        <?= $alumne['user_name'] ?> <?= $alumne['user_surname'] ?>
                        <br />
                        <span class="badge badge-ghost badge-sm font-bold"><?= $alumne['group_name'] ?></span>
                    </td>
                    <td class="text-lg"><?= $alumne['user_birth_date'] ?></td>
                    <td class="text-lg"><?= $alumne['user_phone'] ?></td>
                    <td class="text-lg"><?= $alumne['photo_url'] ?></td>
                    <td class="text-lg">
                        <button class="btn" onclick="openModal('<?= $alumne['user_id'] ?>')">Seleccionar Foto</button>
                    </td>



                </tr>
                <dialog id="my_modal_2" class="modal">
                    <div class="modal-box">
                        <h3 id="modalTitle" class="font-bold text-lg">Hello!</h3>




                        <form action="/uploadPhotoFromFile" method="post" enctype="multipart/form-data"
                            class="flex items-center">
                            <input type="hidden" name="user_id" id="userIdInput" value="">

                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                class="font-semibold">Clica</span> o arrastra la foto</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">JPG, JPEG i PNG</p>
                                    </div>
                                    <input type="file" id="dropzone-file" name="photo"
                                        accept="image/jpeg, image/jpg, image/png" class="">


                                </label>
                            </div>
                            <button type="submit" class="btn btn-active btn-neutral mr-auto mt-2">Pujar Foto</button>
                        </form>

                        <!-- Botón para cerrar el modal -->
                        <button class="btn btn-active btn-neutral ml-auto mt-2" onclick="closeModal()" >Cancelar</button>
                    </div>
                </dialog>

                <?php endforeach; ?>
        </table>
        <!-- Open the modal using ID.showModal() method -->


    </div>

    <?php include "footer.php" ?>
    <script>
    function openModal(userId) {
        // Obtener el elemento del título del modal
        var modalTitle = document.getElementById('modalTitle');

        // Actualizar el contenido del título con el valor de userId
        modalTitle.innerText = 'User ID: ' + userId;

        // Obtener el elemento de entrada oculta para el user_id en el formulario
        var userIdInput = document.getElementById('userIdInput');

        // Actualizar el valor del campo user_id en el formulario
        userIdInput.value = userId;

        // Mostrar el modal
        document.getElementById('my_modal_2').showModal();
    }

    function closeModal() {
        // Cerrar el modal
        document.getElementById('my_modal_2').close();
    }
    // Add JavaScript to handle search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        var searchQuery = this.value.toLowerCase();
        var rows = document.querySelectorAll('.table tbody tr');

        rows.forEach(function(row) {
            var textContent = row.textContent.toLowerCase();
            if (textContent.includes(searchQuery)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    });
    </script>


</body>

</html>