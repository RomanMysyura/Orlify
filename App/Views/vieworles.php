<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <title>Document</title>
</head>

<body>
    <?php require "navbar.php" ?>

    <div class=" border-black">
        <h1 class="text-center text-3xl font-bold mb-3">Les meves orles</h1>
    </div>

    <div class="flex flex-wrap justify-center">

        <?php foreach ($orles as $orla): ?>

        <div class="card w-96 bg-base-100 shadow-xl m-4 border-2 transform transition-transform hover:scale-105">
            <figure><img src="/img/logo.png" alt="Orla Image" class="h-32 w-auto mt-10" /></figure>
            <div class="card-body">
                <h2 class="card-title ml-auto mr-auto"><?= $orla['name_orla'] ?></h2>

                <div class="card-actions justify-center">
                    <button class="btn bg-neutral-300 w-16">
                        <a href="/editar-orles?id=<?= $orla['orla_id'] ?>">
                            <svg width="25px" height="25px" viewBox="0 0 23 23" xmlns="http://www.w3.org/2000/svg">
                                <title>edit</title>
                                <path
                                    d="M3,17.46 L3,20.5 C3,20.78 3.22,21 3.5,21 L6.54,21 C6.67,21 6.8,20.95 6.89,20.85 L17.81,9.94 L14.06,6.19 L3.15,17.1 C3.05,17.2 3,17.32 3,17.46 Z M20.71,7.04 C21.1,6.65 21.1,6.02 20.71,5.63 L18.37,3.29 C17.98,2.9 17.35,2.9 16.96,3.29 L15.13,5.12 L18.88,8.87 L20.71,7.04 Z"
                                    fill="#1D1D1D"></path>
                            </svg>
                        </a>
                    </button>

                    <button class="btn bg-neutral-300 w-16">
                        <a href="/eliminar-orla?id=<?= $orla['orla_id'] ?>">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </button>


                    <button class="btn bg-neutral-300 w-16">
                        <a href="/descarregar-orla?id=<?= $orla['orla_id'] ?>">
                            <svg fill="#000000" width="25px" height="25px" viewBox="0 0 1920 1920"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m0 1016.081 409.186 409.073 79.85-79.736-272.867-272.979h1136.415V959.611H216.169l272.866-272.866-79.85-79.85L0 1016.082ZM1465.592 305.32l315.445 315.445h-315.445V305.32Zm402.184 242.372-329.224-329.11C1507.042 187.07 1463.334 169 1418.835 169h-743.83v677.647h112.94V281.941h564.706v451.765h451.765v903.53H787.946V1185.47H675.003v564.705h1242.353V667.522c0-44.498-18.07-88.207-49.581-119.83Z"
                                    fill-rule="evenodd" />
                            </svg>

                        </a>
                    </button>

                </div>
            </div>
        </div>




        <?php endforeach; ?>




        <a href="/create-new-orla" class="mt-32 w-10 h-10 transform transition-transform hover:scale-125">
            <svg width="80px" height="80px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                <defs></defs>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                    <g id="icon-81-document-add" sketch:type="MSArtboardGroup" fill="#000000">
                        <path
                            d="M20,25 L20,22 L21,22 L21,25 L24,25 L24,26 L21,26 L21,29 L20,29 L20,26 L17,26 L17,25 L20,25 L20,25 Z M16.257162,29 L5.99742191,29 C4.89092539,29 4,28.1012878 4,26.9926701 L4,4.00732994 C4,2.89833832 4.89666625,2 6.00276013,2 L16.5,2 L16.5,2 L17,2 L23,9 L23,9.5 L23,20.5997073 C24.7808383,21.5100654 26,23.3626574 26,25.5 C26,28.5375663 23.5375663,31 20.5,31 C18.7920629,31 17.2659536,30.2215034 16.257162,29 L16.257162,29 L16.257162,29 Z M15.5997095,28 L5.9999602,28 C5.45470893,28 5,27.5543187 5,27.004543 L5,3.99545703 C5,3.45526288 5.44573523,3 5.9955775,3 L16,3 L16,7.99408095 C16,9.11344516 16.8944962,10 17.9979131,10 L22,10 L22,20.2070325 C21.5231682,20.0721672 21.0200119,20 20.5,20 C17.4624337,20 15,22.4624337 15,25.5 C15,26.4002234 15.2162786,27.2499322 15.5997095,28 L15.5997095,28 L15.5997095,28 Z M17,3.5 L17,7.99121523 C17,8.54835167 17.4506511,9 17.9967388,9 L21.6999512,9 L17,3.5 L17,3.5 Z M20.5,30 C22.9852815,30 25,27.9852815 25,25.5 C25,23.0147185 22.9852815,21 20.5,21 C18.0147185,21 16,23.0147185 16,25.5 C16,27.9852815 18.0147185,30 20.5,30 L20.5,30 Z"
                            id="document-add" sketch:type="MSShapeGroup"></path>
                    </g>
                </g>
            </svg>
        </a>









    </div>


    <?php require "footer.php" ?>
</body>

</html>