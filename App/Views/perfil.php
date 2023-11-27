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
                    <div class="w-32 rounded-full">
                        <?php if (!empty($userPhoto)): ?>
                        <a href="/photo"><img src="<?= $userPhoto[0]["url"] ?>" alt="foto de perfil" /></a>
                        <?php else: ?>
                        <p>No hay foto seleccionada</p>
                        <?php endif; ?>
                    </div>
                </div>
                <h2 class="text-center text-lg font-bold mb-5">Les meves dades</h2>

                <input type="text" title="name" id="name" name="name"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="Nom" value="<?= $user['name'] ?>">

                <input type="text" title="surname" id="surname" name="surname"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="Cognom" value="<?= $user['surname'] ?>">

                <input type="text" id="email" title="email" name="email"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="email" value="<?= $user['email'] ?>">

                <input type="text" id="phone" title="phone" name="phone"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="telefon" value="<?= $user['phone'] ?>">

                <input type="text" id="group" title="grup" name="group"
                    class="input bg-transparent rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300"
                    placeholder="Grup" value="<?= isset($group) ? $group : '' ?>" readonly>



                <div class="card-actions justify-end mt-5">
                    <button type="submit" class="btn btn-active btn-neutral">Editar</button>
                </div>
            </div>
        </form>
    </div>

    <?php include "footer.php" ?>
</body>

</html>