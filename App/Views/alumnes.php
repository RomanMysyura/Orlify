<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <script src="/js/bundle.js" defer> </script>
    <script src="/js/buscarAlumnes.js" defer> </script>
    
    <script src="https://cdn.jsdelivr.net/gh/jamesssooi/Croppr.js@2.3.0/dist/croppr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/jamesssooi/Croppr.js@2.3.0/dist/croppr.min.css" rel="stylesheet" />

    <title>Document</title>

    <style>
    @media only screen and (max-width: 700px) {
        video {
            max-width: 100%;
        }
    }
    </style>
</head>

<body>
    <?php include "navbar.php" ?>
    <div class="ml-0 w-full">
        <div class="editar_usuari">

            <div class='max-w-md mx-auto mb-5 '>
                <div
                    class="relative flex items-center w-full h-12 rounded-lg focus-within:shadow-lg bg-white overflow-hidden">
                    <div class="grid place-items-center h-full w-12 text-gray-300 bg-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <input class="peer h-full w-full outline-none text-lg text-gray-700 pr-2 bg-slate-200"
                        title="search" type="text" id="searchInput"
                        placeholder="Buscar alumne per el seu nom, correu... etc." />
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
                    <th class="font-bold text-lg">Rol</th>
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
                    <td class="text-lg"><?= $alumne['user_rol'] ?></td>
                    <td class="text-lg"><?= $alumne['photo_url'] ?></td>
                    
                    <td class="text-lg">
                        <button class="btn modalFoto" data-user-id="<?= $alumne['user_id'] ?>">Actualitzar Foto</button>
                    </td>

                </tr>

                <dialog id="my_modal_2" class="modal">
                    <div class="modal-box w-4/5">
                        <h3 id="modalTitle" class="font-bold text-lg">Hello!</h3>
                        <div class="text flex justify-center items-center">
                            <p class="text-md font-bold mt-2 mb-2">Selecciona una foto o obre la càmera per fer-la
                                tu mateix!</p>
                        </div>
                        <div class="flex justify-center items-center mt-5 mb-5">
                            <button id="cam" name="cam" type="button" value="Obrir càmera"
                                class="btn btn-active btn-neutral  mt-2rounded  before:ease relative h-12 w-40 overflow-hidden border border-grey-800 bg-grey-800 text-grey-300 shadow-2xl transition-all before:absolute before:right-0 before:top-0 before:h-12 before:w-6 before:translate-x-12 before:rotate-6 before:bg-white before:opacity-10 before:duration-700 hover:shadow-gray-800 hover:before:-translate-x-40">
                                <span relative="relative z-10">Obrir càmera</span>
                        </div>

                        <video muted="muted" id="video" style="display: none;"></video>
                        <canvas id="canvas" style="display: none;"></canvas>
                        <div class="flex justify-center items-center mt-5 mb-5 m-10">
                            <button id="capture"
                                class="btn btn-active btn-neutral  mt-2rounded  before:ease relative h-12 w-40 overflow-hidden border border-grey-800 bg-grey-800 text-grey-300 shadow-2xl transition-all before:absolute before:right-0 before:top-0 before:h-12 before:w-6 before:translate-x-12 before:rotate-6 before:bg-white before:opacity-10 before:duration-700 hover:shadow-gray-800 hover:before:-translate-x-40"
                                style="display: none;">Capturar foto</button>
                        </div>







                        <form action="/uploadPhotoFromFile" method="post" enctype="multipart/form-data"
                            class="flex items-center">
                            <input type="hidden" name="user_id" id="userIdInput" value="<?= $alumne['user_id'] ?>">


                            <div class="">
                                <div class="flex items-center justify-center w-full mb-5">
                                    <label for="dropzone-file"
                                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                                        id="dropzone-label">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                    class="font-semibold">Clica</span> o arrossega la foto</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400" id="file-name">JPG, JPEG
                                                i
                                                PNG</p>
                                        </div>
                                        <input type="file" id="dropzone-file" name="photo"
                                            accept="image/jpeg, image/jpg, image/png" class="hidden"
                                            onchange="displayFileName()">
                                    </label>




                                </div>


                                <button type="submit"
                                    class="btn btn-active btn-neutral  ml-20 mt-2rounded  before:ease relative h-12 w-40 overflow-hidden border border-green-800 bg-green-800 text-grey-300 shadow-2xl transition-all before:absolute before:right-0 before:top-0 before:h-12 before:w-6 before:translate-x-12 before:rotate-6 before:bg-white before:opacity-10 before:duration-700 hover:shadow-gray-800 hover:before:-translate-x-40">Pujar
                                    Foto
                                </button>

                        </form>






                        <form method="dialog" style="display: inline-block">
                            <button
                                class="btn btn-active btn-neutral ml-auto mt-2rounded  before:ease relative h-12 w-40 overflow-hidden border border-red-800 bg-red-800 text-grey-300 shadow-2xl transition-all before:absolute before:right-0 before:top-0 before:h-12 before:w-6 before:translate-x-12 before:rotate-6 before:bg-white before:opacity-10 before:duration-700 hover:shadow-gray-800 hover:before:-translate-x-40"
                                id="modalCancelar">Cancelar</button>
                        </form>
                        <form action="/uploadPhotoFromFileEdit" method="post" enctype="multipart/form-data"
                            class="flex items-center">
                            <input type="hidden" name="user_id" id="UserIdInputEdit" value="<?= $alumne['user_id'] ?>">


                            <div class="flex justify-center items-center mt-5 mb-5 m-10">
                                <button type="button" id="EditarFoto"
                                    onclick="toggleEditarFotoSection('<?= $alumne['user_id'] ?>')"
                                    class="btn btn-active btn-neutral mb-5 mt-2rounded  before:ease relative h-12 w-40 overflow-hidden border border-grey-800 bg-grey-800 text-grey-300 shadow-2xl transition-all before:absolute before:right-0 before:top-0 before:h-12 before:w-6 before:translate-x-12 before:rotate-6 before:bg-white before:opacity-10 before:duration-700 hover:shadow-gray-800 hover:before:-translate-x-40">
                                    Editar Foto
                                </button>
                            </div>
                            <div id="DivEditar" style="display: none;"
                                class="flex justify-center items-center mt-5 mb-5 m-10 ml-16">
                                <h1>Retalla la fotografia:</h1>
                                <!-- Editor donde se recortará la imagen con la ayuda de croppr.js -->
                                <div id="editor"></div>

                                <h1>Resultat:</h1>
                                <!-- Previa del recorte -->
                                <canvas id="preview" class="mb-5"></canvas>


                                <!-- Muestra de la imagen recortada en Base64 -->
                                <input type="text" id="base64" name="photo" style="display: none;" readonly>
                                <button type="submit"
                                    class="btn btn-active btn-neutral mr-auto ml-20 mt-2rounded before:ease relative h-12 w-40 overflow-hidden border border-grey-800 bg-grey-800 text-grey-300 shadow-2xl transition-all before:absolute before:right-0 before:top-0 before:h-12 before:w-6 before:translate-x-12 before:rotate-6 before:bg-white before:opacity-10 before:duration-700 hover:shadow-gray-800 hover:before:-translate-x-40">

                                    Pujar Foto Editada
                                </button>
                            </div>

                        </form>
                    </div>

                </dialog>
                <?php endforeach; ?>
            </tbody>
        </table>



    </div>

    <?php include "footer.php" ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="/js/downloadPDF.js"></script>
   
    <script src="/js/editarOrles.js"></script>
    <script src="/js/publishOrla.js"></script>
    <script>

        // Obrir o tancar el div de editar foto
    function toggleEditarFotoSection(user_id) {
        var divEditar = document.getElementById('DivEditar');
        divEditar.style.display = (divEditar.style.display === 'none' || divEditar.style.display === '') ? 'block' :
            'none';

        
        console.log("User ID: ", user_id);
    }



    document.addEventListener('DOMContentLoaded', () => {

        
        const inputImage = document.querySelector('#dropzone-file');
        // El editor
        const editor = document.querySelector('#editor');
        // El canvas
        const miCanvas = document.querySelector('#preview');
        // El context
        const contexto = miCanvas.getContext('2d');
        // La imatge en base64
        let urlImage = undefined;
        
        inputImage.addEventListener('change', abrirEditor, false);

        /**
         * Metode que obre el editor de imatges
         */
        function abrirEditor(e) {
            // Obté la url de la imatge
            urlImage = URL.createObjectURL(e.target.files[0]);

            // Borra l'editor per si hi havia alguna imatge anterior
            editor.innerHTML = '';
            let cropprImg = document.createElement('img');
            cropprImg.setAttribute('id', 'croppr');
            editor.appendChild(cropprImg);

            // Nateja el canvas
            contexto.clearRect(0, 0, miCanvas.width, miCanvas.height);

            // Envia la imatge a l'editor
            document.querySelector('#croppr').setAttribute('src', urlImage);

            // Crea l'editor
            new Croppr('#croppr', {
                aspectRatio: 1,
                startSize: [100, 100],
                onCropEnd: recortarImagen
            })
        }

        /**
         * Metode que retalla la imatge
         */
        function recortarImagen(data) {
            // Variables
            const inicioX = data.x;
            const inicioY = data.y;
            const nuevoAncho = data.width;
            const nuevaAltura = data.height;
            const zoom = 1;
            let imagenEn64 = '';
            // La imprimeix per pantalla
            miCanvas.width = nuevoAncho;
            miCanvas.height = nuevaAltura;
            // Es declara
            let miNuevaImagenTemp = new Image();
            // Quan la imatge canvia, es retalla
            miNuevaImagenTemp.onload = function() {
                // Es retalla
                contexto.drawImage(miNuevaImagenTemp, inicioX, inicioY, nuevoAncho * zoom, nuevaAltura *
                    zoom, 0, 0, nuevoAncho, nuevaAltura);
                // es transforma a base64
                imagenEn64 = miCanvas.toDataURL("image/jpeg");
                // Mostrem el resultat
                document.querySelector('#base64').value = imagenEn64;

                '...">';

            }
            // Proporciona la url de la imatge
            miNuevaImagenTemp.src = urlImage;
        }
    });
    </script>
</body>

</html>