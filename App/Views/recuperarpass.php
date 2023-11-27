<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">

    <title>Document</title>
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="flex flex-col items-center justify-center">
  <div class="w-full max-w-md bg-white border-gray-200 rounded-lg justify-center items-center shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Recuperar contrasenya</h2>

    <form class="flex flex-col">
      <input placeholder="Enter your email address" class="bg-gray-200 text-gray-200 border-0 rounded-md p-2 mb-4 focus:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150" type="email">

      <button class="bg-gradient-to-r from-black to-gray-500  text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-green-600 hover:to-blue-600 transition ease-in-out duration-150" type="submit">Subscribe</button>
    </form>

    <div class="flex justify-center mt-4">
      <a class="text-sm text-gray-400 hover:underline" href="#">Privacy Policy</a>
    </div>
  </div>
</div>




    <?php include "footer.php"; ?>  
    
</body>
</html>