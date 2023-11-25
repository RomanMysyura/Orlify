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

    <div class="flex text-center">

        <div class="w-full max-w-xs md:w-1/3 m-auto mt-5">



            <div class="border-b border-black  w-full">
                <h1 class="font-bold text-xl mb-3">Seleccionar usuarios y grupos</h1>

                <form action="/add_users_to_orla" method="post">
                    <!-- Agregar el campo oculto para el ID de la orla -->
                    <input type="hidden" name="orla_id" value="<?= $orla_id ?>">

                    <?php
    echo '<ul class="menu bg-slate-200 w-full rounded-md ">';
    foreach ($groups as $group) {
        echo '<li>';
        echo '<details>';
        echo '<summary>'. $group['name'] . '</summary>';
        echo '<ul>';

        if (isset($usersInGroups[$group['id']])) {
            foreach ($usersInGroups[$group['id']] as $user) {
                echo '<li><label><input type="checkbox" name="selected_users[]" value=' . $user['id'] . ' />' . $user['name'] . '</label></li>';
            }
        }

        echo '</ul>';
        echo '</details>';
        echo '</li>';
    }
    echo '</ul>';
    ?>

                    <button type="submit" class="btn btn-active btn-neutral">Seleccionar</button>
                </form>

            </div>






            <div class="border-b border-black">
                <h1 class="font-bold text-xl mb-3">Afegir Fotografia</h1>
            </div>
            <form>
                <div class="mb-4">
                    <div class="mt-5">
                        <div class="relative">
                            <input id="name" name="name" type="name" placeholder="Nom"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="surname" name="surname" type="surname" placeholder="Cognom"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="grup" name="grup" type="grup" placeholder="Grup"
                                class="border-b w-full border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit" />
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <input id="images" name="images" type="file" placeholder="Imatges"
                                class="file-input file-input-bordered w-full max-w-xs border-b  border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit"
                                multiple />
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="relative">
                            <!-- Cambiado el tipo de input a "button" y añadido el evento onclick -->
                            <input id="cam" name="cam" type="button" value="Obrir càmera"
                                class="file-input file-input-bordered w-full max-w-xs border-b  border-gray-300 py-1 focus:border-b-2 focus:border-blue-700 transition-colors focus:outline-none peer bg-inherit"
                                onclick="toggleCamera()" />
                        </div>
                    </div>
                    <button
                        class="btn btn-outline mt-5 mb-5 inline-flex items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none"
                        type="submit">
                        Afegir fotografia
                    </button>
                    <video id="video" width="640" height="480" autoplay></video>
                    <button class="btn btn-outline mt-5 mb-5" type="button" id="captureButton"
                        style="display: none;">Capturar Foto</button>
                    <canvas id="canvas" width="325" height="225"></canvas>
                    <a id="downloadLink" class="link link-info" style="display: none;">Descargar Foto</a>
                </div>

            </form>
        </div>

        <div class="w-full w-1/2 m-auto mt-5  rounded-md border-2 border-inherit p-2 shadow-xl">
            <div class="">
                <h1 class="font-bold text-xl mb-3">Usuaris seleccionats</h1>
            </div>
            <div class="flex flex-wrap mt-2 ">
                <?php foreach ($photos as $photo) : ?>
                <div
                    class="photo-container relative overflow-hidden transform transition-transform duration-300 hover:scale-110 mb-5  rounded-md ml-auto mr-auto">
                    <img src="<?= $photo['url'] ?>" alt="<?= $photo['name'] ?>" class="w-36 h-44 m-1 rounded-md ">
                    <p class="font-bold"><?= $photo['name'] ?> </p>

                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>


    <?php include "footer.php" ?>

    <script src="/js/editarOrles.js">

    </script>

</body>

</html>