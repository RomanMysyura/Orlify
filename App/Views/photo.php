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
    <form action="/uploadPhoto" method="post"> <!-- Agrega el atributo 'action' y 'method' -->
    <input type="hidden" name="action" value="uploadPhoto">
    <div class="flex flex-wrap justify-center items-center">
        <?php foreach ($photos as $photo) : ?>
            
        <div class="flex flex-col justify-center items-center mx-4 my-4">
        <input type="hidden" name="userId" value="<?= $photo["id"] ?>">
            <img class="w-40 h-40 rounded-md" src="/uploads/<?= $photo["photo"] ?>" alt="">
            <input type="radio" name="selectedPhoto" id="<?= $photo["photo"] ?>"
                value="<?= $photo["id"] ?>" class="radio mt-5" />
            
        </div>
        <?php endforeach; ?>
    </div>
    <div class="mt-5 flex items-center justify-center">
        <button  for="<?= $photo["photo"] ?>" type="submit"
            class="btn btn-outline inline-flex mt-2 items-center justify-center h-10 px-6 font-medium tracking-wide text-white transition duration-200 bg-black rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
            Guardar
        </button>
    </div>
    <p class="text-center text-md mb-5 mt-5 hover:text-blue-800 transition duration-300"><a href="/contactar">Si hi ha qualsevol error, posa't en contacte amb nosaltres!</a></p>
</form>
    <?php include "footer.php" ?>
</body>

</html>