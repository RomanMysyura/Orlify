<?php

namespace App\Controllers;

use App\Models\Db;
use App\Models\UsersPDO;
use App\Models\Orles;

class NavigationController 
{
   

    public function panelDeControl($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();
    
        $usersModel = new UsersPDO($connection);
        $errorModel = new UsersPDO($connection);
        $orlaModel = new Orles($connection);
    
        $users = $usersModel->getAllUsers();
        $errors = $errorModel->geterror();
        $orles = $orlaModel->getAllOrles();
    
        foreach ($orles as &$orla) {
            $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
        }
    
        $response->set("users", $users);
        $response->set("errors", $errors);
        $response->set("orles", $orles);
    
        // Remove the following line as $photos is not defined here
        // $response->set("photos", $photos);
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

