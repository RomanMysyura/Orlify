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
    <div class="w-full md:max-w-md m-auto bg-gray-100 rounded-md mt-5">
        <div class="card-body items-center text-center ">
            <h2 class="text-center text-lg font-bold mb-5">Les meves dades</h2>
        
            <input type="text" class="input bg-transparent  rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300" placeholder="Nom" value="Joan">
            <input type="text" class="input bg-transparent  rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300" placeholder="Cognom" value="Paneque">
            <input type="text" class="input bg-transparent  rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300" placeholder="email" value="joan@gmail.com">
            <input type="text" class="input bg-transparent  rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300" placeholder="Curs" value="DAW2">
            <input type="text" class="input bg-transparent  rounded-sm outline-none border-b-black hover:bg-white hover:border-bs-blue focus:bg-white focus:outline-none transition-colors duration-300" placeholder="Contrasenya" value="123456">

            
            <div class="card-actions justify-end mt-5">
                <button class="btn btn-active btn-neutral">Editar</button>
            </div>
        </div>
    </div>
   <?php include "footer.php" ?>
</body>
</html>