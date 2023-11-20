<?php

namespace App\Controllers;

use App\Models\Db;
use App\Models\UsersPDO;

class UserController 
{
   
    public function index($request, $response, $container)
    {
        // Obtén la conexión a la base de datos
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        // Crea una instancia del modelo UsersPDO
        $usersModel = new UsersPDO($connection);

        // Obtén todos los usuarios desde el modelo
        $users = $usersModel->getAllUsers();

        // Pasa los datos a la vista
        $response->set("users", $users);

        // Establece la plantilla
        $response->SetTemplate("index.php");

        return $response;
    }
    public function openPerfil($request, $response, $container)
    {
        $response->SetTemplate("perfil.php");

        return $response;
    }
    public function register($request, $response, $container)
    {
        $response->SetTemplate("perfil.php");

        return $response;
    }
}
