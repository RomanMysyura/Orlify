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



            <table class="bg-white border border-gray-300 w-full">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nombre</th>
                        <th class="py-2 px-4 border-b">Apellido</th>
                        <th class="py-2 px-4 border-b">Correo Electrónico</th>
                        <th class="py-2 px-4 border-b">Teléfono</th>
                        <th class="py-2 px-4 border-b">DNI</th>
                        <th class="py-2 px-4 border-b">Fecha de Nacimiento</th>
                        <th class="py-2 px-4 border-b">Curs</th>
                        <th class="py-2 px-4 border-b">Photos</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    <?php foreach ($alumnes as $alumne): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?= $alumne['user_id'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $alumne['user_name'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $alumne['user_surname'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $alumne['user_email'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $alumne['user_phone'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $alumne['user_dni'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $alumne['user_birth_date'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $alumne['group_name'] ?></td>
                        <td class="py-2 px-4 border-b"><?= $alumne['photo_url'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include "footer.php" ?>

    <script>
    // Obtener la referencia del campo de búsqueda y la tabla
    var searchInput = document.getElementById('searchInput');
    var tableBody = document.getElementById('tableBody');

    // Agregar un evento de escucha al campo de búsqueda
    searchInput.addEventListener('input', function() {
        // Obtener el valor del campo de búsqueda
        var searchText = searchInput.value.toLowerCase();

        // Filtrar las filas de la tabla
        var rows = tableBody.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            // Obtener el contenido de la fila y convertirlo a minúsculas
            var rowText = row.textContent.toLowerCase();

            // Ocultar o mostrar la fila según el criterio de búsqueda
            row.style.display = rowText.includes(searchText) ? '' : 'none';
        }
    });
    </script>
</body>

</html>