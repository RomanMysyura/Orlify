<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <title>Perfil</title>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Nueva Contraseña</h2>
        <form class="space-y-4" action="/newpass" method="post">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-600">Correo Electrónico</label>
                <input id="email" name="email" type="email" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600">Contraseña</label>
                <input id="password" name="password" type="password" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 transition ease-in-out duration-150">
                    Guardar Contraseña
                </button>
            </div>
        </form>
    </div>
</body>

</html>
