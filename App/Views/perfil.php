<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <title>Perfil</title>
</head>

<body class="bg-gray-200">
    <?php include "navbar.php" ?>
    <div class="border-b border-black w-90">
        <h4 class="text-center text-4xl font-bold mb-5 mt-5">Perfil</h4>
    </div>
    <div class="w-full max-w-md m-auto bg-gray-100 rounded-md mt-5">
        <form action="/uploadUser" method="post">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <div class="card-body items-center text-center">
                <div class="tooltip avatar" data-tip="Editar foto">
                    <div class="w-24 rounded-full">
                        <a href="/photo"><img src="../img/3.jpeg" /></a>
                    </div>
                </div>
                <h2 class="text-center text-lg font-bold mb-5">Les meves dades</h2>

                <label for="nombre">Nom:</label>
                <input type="text" id="name" name="name"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="Nom" value="<?= $user['name'] ?>">

                <label for="cognom">Cognom:</label>
                <input type="text" id="surname" name="surname"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="Cognom" value="<?= $user['surname'] ?>">

                <label for="email">Email:</label>
                <input type="text" id="email" name="email"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="email" value="<?= $user['email'] ?>">
                <label for="email">telefon:</label>
                <input type="text" id="phone" name="phone"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="telefon" value="<?= $user['phone'] ?>">
                    <label for="group">Grup:</label>
<input type="text" id="group" name="group" class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300" placeholder="Grup" value="<?= isset($group) ? $group : '' ?>">


                <div class="card-actions justify-end mt-5">
                    <button type="submit" class="btn btn-active btn-neutral">Editar</button>
                </div>
            </div>
        </form>
    </div>

    <?php include "footer.php" ?>
</body>

</html>