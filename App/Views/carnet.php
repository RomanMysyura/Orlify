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

    <div class="card w-2/6 bg-base-100 shadow-xl mx-auto mt-20 ">
    <img src="img/user.png" alt="Imagen de perfil" class="w-32 h-32 object-cover rounded-l">
    <div class="card-body flex-grow ml-auto text-right">
        <h2 class="card-title">Nom: <?= $user['name']; ?></h2>
        <h2 class="card-title">Cognom: <?= $user['surname']; ?></h2>
        <h2 class="card-title">Curs: <?= $user['curso']; ?></h2>
        <div class="card-actions justify-end">
        </div>
    </div>
</div>






    <?php include "footer.php" ?>
</body>

</html>
