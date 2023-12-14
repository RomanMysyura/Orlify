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

       
            <?php if ($orla['status'] == 'Public'): ?>
                <div class="card w-96 bg-base-100 shadow-xl m-4 border-2 transform transition-transform hover:scale-105">
           
            <figure><img src="/img/logo.png" alt="Orla Image" class="h-32 w-auto mt-10" /></figure>
            <div class="card-body">
                <h2 class="card-title ml-auto mr-auto"><?= $orla['name_orla'] ?></h2>

                <div class="card-actions justify-center">


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
            <?php else: ?>
            

            <?php endif; ?>


           
        


        <?php endforeach; ?>



    </div>


    <?php require "footer.php" ?>
</body>

</html>