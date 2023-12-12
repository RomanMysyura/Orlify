<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>

    <?php include "navbar.php" ?>

    <div class="flex items-center justify-center">
        <form id="updateNameForm" action="/updateNameOrla" method="POST">
            <input type="text" name="id_orla" value="<?= $orla_id ?>" style="display: none;">
            <input type="text" placeholder="<?= $orlaName ?>" name="nom" id="nom"
                class="input w-auto text-4xl text-center bg-slate-100 font-bold shadow-inner" value="<?= $orlaName ?>"
                onkeydown="submitOnEnter(event)">
        </form>

    </div>



    <div class="flex text-center">

        <div class="w-full max-w-xs md:w-1/3 m-auto mt-5 ml-20 mr-20">





            <div class=" w-full">
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
                echo '<li><label><input type="checkbox" name="selected_users[]" value=' . $user['id'] . ' />' . $user['name'] .' '. $user['surname'] . '</label></li>';
            }
        }

        echo '</ul>';
        echo '</details>';
        echo '</li>';
    }
    echo '</ul>';
    ?>

                    <button type="submit"
                        class="btnseleccionar btn btn-active btn-neutral mt-5 mb-10">Seleccionar</button>
                </form>

            </div>


           

        </div>

        <div class=" w-1/2 m-auto mt-5  ">

            <div class="">
                <ul class="menu bg-slate-200 lg:menu-horizontal rounded-t-lg  w-full">
                    <li>
                        <a>
                            <!-- Reemplaza el siguiente código con tu ícono de perfil SVG -->
                            <svg enable-background="new 0 0 500 500" id="Layer_1" version="1.1" viewBox="0 0 500 500"
                                xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" class="h-8 w-8">
                                <g>
                                    <g>
                                        <path
                                            d="M250,291.6c-52.8,0-95.8-43-95.8-95.8s43-95.8,95.8-95.8s95.8,43,95.8,95.8S302.8,291.6,250,291.6z M250,127.3    c-37.7,0-68.4,30.7-68.4,68.4s30.7,68.4,68.4,68.4s68.4-30.7,68.4-68.4S287.7,127.3,250,127.3z" />
                                    </g>
                                    <g>
                                        <path
                                            d="M386.9,401.1h-27.4c0-60.4-49.1-109.5-109.5-109.5s-109.5,49.1-109.5,109.5h-27.4c0-75.5,61.4-136.9,136.9-136.9    S386.9,325.6,386.9,401.1z" />
                                    </g>
                                </g>
                            </svg>
                            Alumnes
                            <span
                                class="badge badge-sm text-base"><?php $numeroDeFotos = count($photos); echo $numeroDeFotos;?></span>
                        </a>
                    </li>

                    <li>

                        <a href="/descarregar-orla/<?= $_SESSION["orla_id"] ?>" id="downloadPDF">
                            <svg fill="#000000" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8">
                                <path
                                    d="m0 1016.081 409.186 409.073 79.85-79.736-272.867-272.979h1136.415V959.611H216.169l272.866-272.866-79.85-79.85L0 1016.082ZM1465.592 305.32l315.445 315.445h-315.445V305.32Zm402.184 242.372-329.224-329.11C1507.042 187.07 1463.334 169 1418.835 169h-743.83v677.647h112.94V281.941h564.706v451.765h451.765v903.53H787.946V1185.47H675.003v564.705h1242.353V667.522c0-44.498-18.07-88.207-49.581-119.83Z"
                                    fill-rule="evenodd" />
                            </svg>
                            Exportar
                            <span class="badge badge-sm badge-error">PDF</span>
                        </a>
                    </li>
                    <li class="ml-auto">
                        <a>
                            <?php echo $orlaStatus; ?>
                            <input type="checkbox" class="toggle toggle-success" id="checkboxToggle"
                                value="<?php echo $orla_id; ?>"
                                <?php echo ($orlaStatus === 'Public') ? 'checked' : ''; ?> />
                        </a>




                    </li>

                </ul>
            </div>

            <div class="loading-indicator fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-gray-500 bg-opacity-75 z-50"
                style="display: none;">
                <span class="loading loading-spinner loading-lg text-white"></span>

            </div>




            <div class=" bg-slate-200 rounded-b-lg border-2 border-inherit  p-2">

                <div class="flex flex-wrap mt-2 ">

                    <?php foreach ($photos as $photo) : ?>
                    <div
                        class="photo-container relative overflow-hidden transform transition-transform duration-300 hover:scale-110 mb-5  rounded ml-auto mr-auto">
                        <img src="<?= $photo['url'] ?>" alt="<?= $photo['name'] ?>" class="w-36 h-44 m-1 rounded-md ">
                        <p class="font-bold "><?= $photo['name'] ?> </p>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>

        </div>



    </div>


    <script>



    </script>

    <?php include "footer.php" ?>
    
    <script src="/js/downloadPDF.js"></script>

    <script src="/js/editarOrles.js"></script>
    <script src="/js/publishOrla.js"></script>
    <script>
    
function submitOnEnter(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("updateNameForm").submit();  
        
    }

}



    </script>


</body>

</html>