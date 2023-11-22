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

    <div class="border-b border-black">
        <h1 class="text-center text-3xl font-bold mb-3">Les meves orles</h1>
    </div>

    <div class="flex flex-wrap justify-center">

    <?php foreach ($orles as $orla): ?>
        
        <div class="card w-96 bg-base-100 shadow-xl m-4">
            <figure class="px-10 pt-10">
                <img src="../../img/<?= $orla['url'] ?>" alt="Orla Image" class="rounded-xl" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title"><?= $orla['status'] ?></h2>
                <div class="card-actions">
                    <button class="btn btn-outline btn-sm mt-3 mr-8">Descarregar</button>
                    <button class="btn btn-outline btn-success btn-sm mt-3 ml-8">
                        <a href="/editar-orles?id=<?= $orla['orla_id'] ?>">Editar</a>
                    </button>
                    <input type="hidden" id="orlaId" value="<?= $orla['orla_id'] ?>">
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>


    <?php require "footer.php" ?>
</body>
</html>
