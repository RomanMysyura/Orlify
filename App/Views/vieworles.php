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


            <?php if ($orla['status'] == 'Public'): ?>
            <div class="ml-auto mr-1 mt-1">
                <svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.0.3 (7891) - http://www.bohemiancoding.com/sketch -->
                    <title>icon 116 lock open</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <g id="icon-116-lock-open" sketch:type="MSArtboardGroup" fill="#57cc99">
                            <path
                                d="M16,23.9146472 L16,26.5089948 C16,26.7801695 16.2319336,27 16.5,27 C16.7761424,27 17,26.7721195 17,26.5089948 L17,23.9146472 C17.5825962,23.708729 18,23.1531095 18,22.5 C18,21.6715728 17.3284272,21 16.5,21 C15.6715728,21 15,21.6715728 15,22.5 C15,23.1531095 15.4174038,23.708729 16,23.9146472 L16,23.9146472 L16,23.9146472 Z M24,9.5 L24,8.499235 C24,4.35752188 20.6337072,1 16.5,1 C12.3578644,1 9,4.35670485 9,8.499235 L9,16.0000125 L9,16.0000125 C7.34233349,16.0047152 6,17.339581 6,19.0094776 L6,28.9905224 C6,30.652611 7.34559019,32 9.00878799,32 L23.991212,32 C25.6529197,32 27,30.6633689 27,28.9905224 L27,19.0094776 C27,17.3503174 25.6591471,16.0047488 24,16 L22.4819415,16 L12.0274777,16 C12.0093222,15.8360041 12,15.6693524 12,15.5005291 L12,8.49947095 C12,6.01021019 14.0147186,4 16.5,4 C18.9802243,4 21,6.01448176 21,8.49947095 L21,9.5 L21,12.1239591 C21,13.1600679 21.6657972,14 22.5,14 C23.3284271,14 24,13.1518182 24,12.1239591 L24,9.5 L24,9.5 L24,9.5 Z"
                                id="lock-open" sketch:type="MSShapeGroup"></path>
                        </g>
                    </g>
                </svg>
            </div>

            <?php else: ?>
            <div class="ml-auto mr-1 mt-1">
                <svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.0.3 (7891) - http://www.bohemiancoding.com/sketch -->
                    <title>icon 114 lock</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <g id="icon-114-lock" sketch:type="MSArtboardGroup" fill="#e63946">
                            <path
                                d="M16,21.9146472 L16,24.5089948 C16,24.7801695 16.2319336,25 16.5,25 C16.7761424,25 17,24.7721195 17,24.5089948 L17,21.9146472 C17.5825962,21.708729 18,21.1531095 18,20.5 C18,19.6715728 17.3284272,19 16.5,19 C15.6715728,19 15,19.6715728 15,20.5 C15,21.1531095 15.4174038,21.708729 16,21.9146472 L16,21.9146472 Z M9,14.0000125 L9,10.499235 C9,6.35670485 12.3578644,3 16.5,3 C20.6337072,3 24,6.35752188 24,10.499235 L24,14.0000125 C25.6591471,14.0047488 27,15.3503174 27,17.0094776 L27,26.9905224 C27,28.6633689 25.6529197,30 23.991212,30 L9.00878799,30 C7.34559019,30 6,28.652611 6,26.9905224 L6,17.0094776 C6,15.339581 7.34233349,14.0047152 9,14.0000125 L9,14.0000125 L9,14.0000125 Z M12,14 L12,10.5008537 C12,8.0092478 14.0147186,6 16.5,6 C18.9802243,6 21,8.01510082 21,10.5008537 L21,14 L12,14 L12,14 L12,14 Z"
                                id="lock" sketch:type="MSShapeGroup"></path>
                        </g>
                    </g>
                </svg>
            </div>

            <?php endif; ?>



            <figure><img src="/img/logo.png" alt="Orla Image" class="h-32 w-auto mt-10" /></figure>
            <div class="card-body">
                <h2 class="card-title ml-auto mr-auto"><?= $orla['name_orla'] ?></h2>

                <div class="card-actions justify-center">

                    <a href="/editar-orles?id=<?= $orla['orla_id'] ?>">
                        <button class="btn bg-neutral-300 w-16">
                            <svg width="25px" height="25px" viewBox="0 0 23 23" xmlns="http://www.w3.org/2000/svg">
                                <title>edit</title>
                                <path
                                    d="M3,17.46 L3,20.5 C3,20.78 3.22,21 3.5,21 L6.54,21 C6.67,21 6.8,20.95 6.89,20.85 L17.81,9.94 L14.06,6.19 L3.15,17.1 C3.05,17.2 3,17.32 3,17.46 Z M20.71,7.04 C21.1,6.65 21.1,6.02 20.71,5.63 L18.37,3.29 C17.98,2.9 17.35,2.9 16.96,3.29 L15.13,5.12 L18.88,8.87 L20.71,7.04 Z"
                                    fill="#1D1D1D"></path>
                            </svg>
                        </button>
                    </a>

                    <a href="/eliminar-orla?id=<?= $orla['orla_id'] ?>">
                        <button class="btn bg-neutral-300 w-16">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </a>

                    <a href="/descarregar-orla/<?= $orla['orla_id'] ?>">
                        <button class="btn bg-neutral-300 w-16">
                            <svg fill="#000000" width="25px" height="25px" viewBox="0 0 1920 1920"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m0 1016.081 409.186 409.073 79.85-79.736-272.867-272.979h1136.415V959.611H216.169l272.866-272.866-79.85-79.85L0 1016.082ZM1465.592 305.32l315.445 315.445h-315.445V305.32Zm402.184 242.372-329.224-329.11C1507.042 187.07 1463.334 169 1418.835 169h-743.83v677.647h112.94V281.941h564.706v451.765h451.765v903.53H787.946V1185.47H675.003v564.705h1242.353V667.522c0-44.498-18.07-88.207-49.581-119.83Z"
                                    fill-rule="evenodd" />
                            </svg>
                        </button>

                    </a>

                </div>
            </div>
        </div>




        <?php endforeach; ?>



        <div class="card w-96 h-96 bg-base-100 shadow-xl m-4 border-2 transform transition-transform hover:scale-105">


           

            <div class="card-body">
            <a href="/create-new-orla" class="mt-20 ml-24 ">
            <svg width="160px" height="160px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
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

                <div class="card-actions justify-center">

                 
                </div>
            </div>
        </div>




        









    </div>


    <?php require "footer.php" ?>
</body>

</html>