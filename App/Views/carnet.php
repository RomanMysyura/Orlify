<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/main.css">
  <style>
    /* Agrega reglas CSS para el fondo */
    .card {
      background-image: url('../img/carnet.jpg'); /* Reemplaza 'ruta/a/tu/carpeta/' con la ruta correcta */
      background-size: cover;
      background-position: center;
    }

    /* Establece el color blanco para el texto en las etiquetas h3 y p */
    .card h3, .card p {
      color: white;
    }

    /* Aumenta el z-index de la imagen del usuario */
    .user-photo {
      z-index: 2; /* Ajusta según sea necesario */
    }
  </style>
  <title>Crear Carnet</title>
</head>

<body class="bg-gray-200">
  <?php include "navbar.php" ?>

  <div class="flex items-center card w-1/3 h-60 shadow-lg mx-auto mt-20 overflow-hidden rounded-md text-center relative">
    <div class="flex items-center p-3 h-60 rounded-md mr-5">
      <section class="flex justify-center items-center w-32 h-32 rounded-full shadow-md z-50">
        <?php if (!empty($photo)): ?>
          <!-- Aplica border-radius al contenedor de la imagen -->
          <img src="../<?= $photo[0]['url'] ?>" class="rounded-full w-full h-full object-cover" alt="Foto"/>
        <?php else: ?>
          <img src="../img/user.png"/>
        <?php endif; ?>
      </section>

      <section class="flex-grow border-gray-300 m-3 pr-3 ml-12">
        <div>
          <p class="text-gray-400 text-lg ml-12 text-justify">
            Nom: <?= $user['name']; ?>
          </p>
          <p class="text-gray-400 text-lg ml-12 text-justify">
            Cognom: <?= $user['surname']; ?>
          </p>
          <p class="text-gray-400 text-lg ml-12 text-justify">
            Grup: <?= isset($group) ? $group : 'N/A'; ?>
          </p>
          <p class="text-gray-400 text-lg ml-12 text-justify">
            Rol: <?= $user['role']; ?>
          </p>
        </div>
      </section>
    </div>
  </div>

  <?php include "footer.php" ?>
</body>

</html>
