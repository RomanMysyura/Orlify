<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <style>
    /* Agrega reglas CSS para el fondo */
    .card {
        background-image: url('../img/carnet.jpg');
        /* Reemplaza 'ruta/a/tu/carpeta/' con la ruta correcta */
        background-size: cover;
        background-position: center;
    }

    /* Establece el color blanco para el texto en las etiquetas h3 y p */
    .card h3,
    .card p {
        color: white;
    }

    /* Aumenta el z-index de la imagen del usuario */
    .user-photo {
        z-index: 2;
        /* Ajusta según sea necesario */
    }
    </style>
    <title>Crear Carnet</title>
</head>

<body class="bg-gray-200">
    <?php include "navbar.php" ?>





    <div class="w-full mt-20 dark:bg-slate-800 gap-6 flex items-center justify-center h-80">
        <div
            class="profilecard bg-gray-100 dark:bg-gray-700 relative shadow-xl overflow-hidden hover:shadow-2xl group rounded-xl p-5 transition-all duration-500 transform flex items-center">
          
            <div class="flex items-center gap-4">
                <img src="../<?= $photo[0]['url'] ?>"
                    class="w-32 group-hover:w-36 group-hover:h-36 h-32 object-center object-cover rounded-full transition-all duration-500 delay-500 transform" />
                <div class="w-fit transition-all transform duration-500">
                    <h1 class="text-gray-600 dark:text-gray-200 font-bold text-3xl">
                        <?= $user['surname']; ?> <?= $user['name']; ?>
                    </h1>
                    <p class="text-gray-400 text-2xl"><?= $user['role']; ?></p>
                    <a
                        class="text-xl text-gray-500 dark:text-gray-200 group-hover:opacity-100 opacity-0 transform transition-all delay-300 duration-500">
                        <?= $user['email']; ?>
                    </a>
                    <br>
                    <a
                        class="text-xl text-gray-500 dark:text-gray-200 group-hover:opacity-100 opacity-0 transform transition-all delay-300 duration-500">
                        <?= isset($group) ? $group : 'N/A'; ?>
                    </a>
                </div>
            </div>
            <div class="flex items-center justify-end mt-4 ml-auto">
                <img src="/img/QrCodeCarnet.png" alt=""
                    class="w-28 h-28 object-cover rounded-full transition-all duration-500 delay-500 transform" />
            </div>
        </div>


    </div>
    <?php include "footer.php" ?>
</body>

</html>