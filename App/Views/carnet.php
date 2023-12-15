<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/main.css">
  <style>
    /* Agrega reglas CSS para el fondo */
    .card {
      background-image: url('../img/carnet.jpg');
      background-size: cover;
      background-position: center;
    }

    /* Establece el color blanco para el texto en las etiquetas h3 y p */
    .card h3,
    .card p {
      color: white;
    }

    /* Aumenta el z-index de la imagen del usuario */
    .user-photo {
      z-index: 2;
    }

    /* Establece el ancho y alto del carnet en porcentaje para que sea responsive */
    .card {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      width: 90%;
      max-width: 800px;
      margin: 0 auto;
      height: 60vh;
    }

    /* Establece la altura del contenedor de la imagen */
    .user-photo {
      height: 100%;
    }

    /* Ajusta el tamaño de la fuente y el espaciado en pantallas más pequeñas */
    .card h3,
    .card p {
      font-size: 18px;
      line-height: 1.6;
      text-align: justify;
    }

    /* Ajusta la posición del texto */
    .text-container {
      margin-left: 20px; /* Ajusta según sea necesario para cambiar la posición del texto */
      text-align: left; /* Alinea el texto a la izquierda */
    }

    @media screen and (max-width: 600px) {
      .card h3,
      .card p {
        font-size: inherit;
        line-height: 1.4;
      }

      /* Ajusta la posición del texto en pantallas pequeñas si es necesario */
      .text-container {
        margin-left: 0;
        text-align: center;
      }
    }
  </style>
  <title>Crear Carnet</title>
</head>

<body class="bg-gray-200">
  <?php include "navbar.php" ?>

  <div class="card w-full h-auto shadow-lg mx-auto mt-20 overflow-hidden rounded-md text-center relative">
    <div class="flex items-center p-3 h-auto rounded-md">
      <section class="flex justify-center items-center w-1/3 h-auto rounded-full shadow-md z-50 user-photo">
        <?php if (!empty($photo)): ?>
          <img src="../<?= $photo[0]['url'] ?>" class="rounded-full w-full h-full object-cover" alt="Foto" />
        <?php else: ?>
          <img src="../img/user.png" />
        <?php endif; ?>
      </section>

      <section class="flex-grow border-gray-300 m-3 pr-3 ml-12 text-container">
        <div>
          <p class="text-gray-400 text-lg">
            Nom: <?= $user['name']; ?>
          </p>
          <p class="text-gray-400 text-lg">
            Cognom: <?= $user['surname']; ?>
          </p>
          <p class="text-gray-400 text-lg">
            Curs: <?= isset($group) ? $group : 'N/A'; ?>
          </p>
          <p class="text-gray-400 text-lg">
            Rol: <?= $user['role']; ?>
          </p>
        </div>
      </section>
    </div>
  </div>

  <?php include "footer.php" ?>
</body>

</html>
