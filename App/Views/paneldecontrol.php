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
        $(".editorles, .editphoto").hide();

        $("#editarUsuarioBtn").click(function() {
            $(".editar_usuari, .editorles, .editphoto").hide();
            $("#editorlesBtn, #editphotoBtn").removeClass("bg-gray-400").addClass("bg-white");

            $(".editar_usuari").show();

            $(this).removeClass("bg-white").addClass("bg-gray-400");
        });

        $("#editorlesBtn").click(function() {
            $(".editar_usuari, .editorles, .editphoto").hide();
            $("#editarUsuarioBtn, #editphotoBtn").removeClass("bg-gray-400").addClass("bg-white");

            $(".editorles").show();

            $(this).removeClass("bg-white").addClass("bg-gray-400");
        });

        $("#editphotoBtn").click(function() {
            $(".editar_usuari, .editorles, .editphoto").hide();
            $("#editarUsuarioBtn, #editorlesBtn").removeClass("bg-gray-400").addClass("bg-white");

            $(".editphoto").show();

            $(this).removeClass("bg-white").addClass("bg-gray-400");
        });
    });
    
    </script>
</body>

</html>