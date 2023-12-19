<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <title>Crear Carnet</title>
    <link rel="manifest" href="/manifest.json">
</head>

<body class="bg-gray-200">
    <?php include "navbar.php" ?>





    <div class="w-full mt-20 dark:bg-slate-800 gap-6 flex items-center justify-center h-80">
        <div
            class="profilecard bg-gray-100 dark:bg-gray-700 relative shadow-xl overflow-hidden hover:shadow-2xl group rounded-xl p-5 transition-all duration-500 transform flex items-center">
          
            <div class="flex items-center gap-4">
            <?php if (!empty($photo)): ?>
                <img src="../<?= $photo[0]['url'] ?>" class="w-36 h-36 object-cover rounded-full"/>
                <?php else: ?>
                            <img src="../img/user2.png" class="w-36 h-36 object-cover rounded-full"/>
                        <?php endif; ?>
                <div class="w-fit transition-all transform duration-500">
                    <h1 class="text-gray-600 dark:text-gray-200 font-bold text-3xl">
                        <?= $user['surname']; ?> <?= $user['name']; ?>
                    </h1>
                    <p class="text-gray-500 text-2xl"><?= $user['role']; ?></p>
                    <a
                        class="text-xl text-gray-600 dark:text-gray-200 group-hover:opacity-100 opacity-0 transform transition-all delay-300 duration-500">
                        <?= $user['email']; ?>
                    </a>
                    <br>
                    <a
                        class="text-xl text-gray-600 dark:text-gray-200 group-hover:opacity-100 opacity-0 transform transition-all delay-300 duration-500">
                        <?= isset($group) ? $group : 'N/A'; ?>
                    </a>
                </div>
            </div>
           
        </div>


    </div>
    <?php include "footer.php" ?>
</body>

</html>
