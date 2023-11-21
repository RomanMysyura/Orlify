<?php

namespace App\Controllers;

use App\Models\Db;
use App\Models\UsersPDO;

class NavigationController 
{
   
    public function contactar($request, $response, $container)
    {
        $response->SetTemplate("contactar.php");

        return $response;
    }
    public function crearOrles($request, $response, $container)
    {
        $response->SetTemplate("crearOrles.php");

        return $response;
    }

    public function panelDeControl($request, $response, $container)
{
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);

        $users = $usersModel->getAllUsers();

        $response->set("users", $users);

        $response->SetTemplate("paneldecontrol.php");

        return $response;
}

}