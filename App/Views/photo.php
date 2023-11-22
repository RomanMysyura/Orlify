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
<div class="border-b border-black w-90">
    <h4 class="text-center text-xl font-bold mb-5 mt-5">Escull la teva fotografia</h4>
</div>
<p class="text-center text-md mb-5 mt-5">La fotografia seleccionada serà la que surti a la orla del teu curs.</p>
<div class="flex flex-wrap justify-center items-center">
    <?php foreach ($photos as $photo) : ?>
        <div class="flex flex-col justify-center items-center mx-4 my-4">
            <img class="w-40 h-40 rounded-md" src="/uploads/<?= $photo["photo"] ?>" alt="">
            <input type="radio" name="selectedPhoto" id="<?= $photo["photo"] ?>" value="<?= $photo["photo"] ?>" class="radio  mt-5" />
            <label for="<?= $photo["photo"] ?>" class=" hidden cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md mt-5"></label>
        </div>
    <?php endforeach; ?>
</div>
    <?php include "footer.php" ?>
</body>
</html>