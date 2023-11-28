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
                    <td class="text-lg"><button type="submit" class="btn btn-active btn-neutral mr-auto">Seleccionar foto</button></td>
                    <th>
                        <form action="/uploadPhotoFromFile" method="post" enctype="multipart/form-data"
                            class="flex items-center ">
                            <input type="hidden" name="user_id" value="<?= $alumne['user_id'] ?>">
                            <input type="file" name="photo" accept="image/jpeg, image/jpg, image/png"
                                class="ml-auto mr-auto">
                            <button type="submit" class="btn btn-active btn-neutral mr-auto">Pujar Foto</button>
                        </form>
                    </th>
                </tr>
                <?php endforeach; ?>
        </table>
    </div>

    <?php include "footer.php" ?>
    <script>
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