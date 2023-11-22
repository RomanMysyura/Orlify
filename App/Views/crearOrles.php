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

<div class="container mx-auto mt-8">
    
    <form class="max-w-md mx-auto bg-white p-8 border border-gray-300" action="/create-new-orla" method="post">
        
        <div class="mb-4">
            <label for="nombre" class="block text-gray-600 text-sm font-semibold mb-2">Nom</label>
            <input type="text" id="nombre" name="nombre" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        
        <div class="mb-4">
            <label for="grupo" class="block text-gray-600 text-sm font-semibold mb-2">Grup</label>
            <input type="text" id="grupo" name="grupo" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
        </div>

      
        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-700">
                Enviar
            </button>
        </div>
    </form>
</div>

<?php include "footer.php" ?>

</body>
</html>