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

  <div
    class="flex items-center card  w-1/3 h-40 bg-white shadow-lg mx-auto mt-20 overflow-hidden rounded-md text-center relative">
    <div class="flex items-center p-3 h-40 bg-white rounded-md mr-5">
      <section
        class="flex justify-center items-center w-24 h-24 rounded-full  shadow-md bg-gradient-to-r from-[#141313] to-[#999999 ] hover:from-[#C9A9E9] hover:to-[#7EE7FC] hover:cursor-pointer hover:scale-110 duration-300">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <?php if (!empty($photo)): ?>
          <a href="/photo"><img src="../<?= $photo[0]['url'] ?>"/></a>
        <?php else: ?>
          <p>No hay foto seleccionada</p>
        <?php endif; ?>
        </svg>
      </section>

      <section class="block border-l border-gray-300 m-3">
        <div class="pl-3">
          <h3 class="text-gray-600 font-semibold text-sm">
            <?= $user['name']; ?>
          </h3>
          <h3 class="text-gray-600 font-semibold text-sm">
            <?= $user['surname']; ?>
          </h3>
          <h3 class="bg-clip-text text-transparent bg-gradient-to-l from-[#005BC4] to-[#27272A] text-lg font-bold">
            <?= isset($group) ? $group : '' ?>
          </h3>
        </div>
      </section>
      <section class="flex items-center justify-center ml-14">
        <div class="">
          <img src="../img/qr.png" alt="Ejemplo" class="w-20 h-20 object-cover">
        </div>
      </section>
    </div>
  </div>






  <?php include "footer.php" ?>
</body>

</html>