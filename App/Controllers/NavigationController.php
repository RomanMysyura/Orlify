<?php

namespace App\Controllers;


class NavigationController 
{
   
    public function panelDeControl($request, $response, $container)
    {
       
        $usersModel = $container["\App\Models\usersPDO"];
        $errorModel = $container["\App\Models\usersPDO"];
        $orlaModel = $container["\App\Models\Orles"];
    
        $users = $usersModel->getAllUsers();
        $errors = $errorModel->geterror();
        $orles = $orlaModel->getAllOrles();
        
        foreach ($users as &$user) {
            $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        }
    
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
        $usersModel = $container["\App\Models\usersPDO"];
        $response->SetTemplate("recuperarpass.php");
        return $response;
    }
   
}

