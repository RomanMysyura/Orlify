<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <title>Crear Carnet</title>
</head>

<body class="bg-gray-200">
    <?php include "navbar.php" ?>

    <div class="card w-2/6 bg-white shadow-xl mx-auto mt-20 overflow-hidden rounded-lg text-center relative">
    <div class="border-b border-black w-90">
        <div class="flex items-start justify-start ml-4 mt-4">
            <img src="img/logo.png" alt="Logo" class="w-12 h-12 object-cover">
            <div class="mx-auto">
                <h1 class="text-2xl font-bold mt-2 mb-2 text-black mr-8">CARNET</h1>
            </div>
        </div>
    </div>
    <div class="flex">
        <img src="img/user.png" alt="Imagen de perfil" class="w-32 h-32 object-cover rounded-bl mb-6">
        <div class="card-body flex-grow ml-4 p-4 text-left flex justify-between">
            <div>
                <h2 class="card-title text-black ml-20"><?= $user['name']; ?></h2>
                <h2 class="card-title text-black ml-20"><?= $user['surname']; ?></h2>
                <h2 class="card-title text-black ml-20"><?= $user['curso']; ?></h2>
            </div>
        </div>
        <img src="img/qr.png" alt="Ejemplo" class="w-24 h-24 object-cover mr-6 mt-4">
    </div>
    <div class="card-actions justify-end bg-black text-white p-4 rounded-b-lg absolute bottom-0 w-full">
    </div>
</div>



    <?php include "footer.php" ?>
</body>

</html>
