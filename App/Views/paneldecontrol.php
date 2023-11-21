<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/main.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title><?=$app_config["app"]["name"]?></title>
</head>

<body class="bg-gray-200">
    <?php include "navbar.php" ?>

    <div class="flex">
        <!-- Menú a la izquierda -->
        <div class="flex flex-col w-36">
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="editarUsuarioBtn">Editar Usuari</a>
            <a href="#" class="p-4 bg-white hover:bg-gray-400" id="productesBtn">Productes</a>
        </div>

        <!-- Textos a la derecha -->
        <div class="ml-4">
            <div class="editar_usuari">
                <h1>Editar usuari</h1>
            </div>
            <div class="productes">
                <h1>Productes</h1>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

    <script>
        $(document).ready(function () {
            // Ocultar ambos divs al inicio
            $(".editar_usuari, .productes").hide();

            // Manejar clic en "Editar Usuari"
            $("#editarUsuarioBtn").click(function () {
                $(".editar_usuari").show();
                $(".productes").hide();
            });

            // Manejar clic en "Productes"
            $("#productesBtn").click(function () {
                $(".editar_usuari").hide();
                $(".productes").show();
            });
        });
    </script>
</body>

</html>
