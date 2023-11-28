<?php

namespace App\Controllers;

use App\Models\Db;
use App\Models\UsersPDO;

class NavigationController 
{
   

    public function panelDeControl($request, $response, $container)
{
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);
        $errorModel = new UsersPDO($connection);

        $users = $usersModel->getAllUsers();
        $errors = $errorModel->geterror();

        $response->set("users", $users);
        $response->set("errors", $errors);


        $response->SetTemplate("paneldecontrol.php");

        return $response;
    }
   
    public function recuperarpass($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);
        $response->SetTemplate("recuperarpass.php");
        return $response;
    }
   
}

