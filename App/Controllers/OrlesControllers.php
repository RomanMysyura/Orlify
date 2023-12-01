<?php

namespace App\Controllers;

use App\Models\Db;
use App\Models\UsersPDO;
use App\Models\Orles;
class OrlesControllers 
{

    public function orles($request, $response, $container)
    {

        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $OrlaModel = new Orles($connection);

        $userId = $_SESSION["user_id"];


        $orla = $OrlaModel->getOrles($userId);

        $response->set("orles", $orla);


        $response->SetTemplate("vieworles.php");
        return $response;
    }


   

    public function editarOrles($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();
    
        $orla_id = $_GET["id"];
        $OrlaModel = new Orles($connection);
        $photos = $OrlaModel->getPhotosForOrla($orla_id);
        $response->set("photos", $photos);
        $response->set("orla_id", $orla_id);
        $orlaName = $OrlaModel->getOrlaName($orla_id);
        $response->set("orlaName", $orlaName);
        // Obtener la lista de usuarios y grupos
        $usersModel = new UsersPDO($connection);
        $users = $usersModel->getAllUsers();
        $groups = $usersModel->getAllGroups();
    
        // Pasar la lista de usuarios y grupos a la vista
        $response->set("users", $users);
        $response->set("groups", $groups);
        

        // Para cada grupo, obtener los usuarios del grupo
        $usersInGroups = [];
        foreach ($groups as $group) {
            $usersInGroup = $usersModel->getUsersInGroup($group['id']);
            $usersInGroups[$group['id']] = $usersInGroup;
        }
    
        // Pasar la lista de usuarios en grupos a la vista
        $response->set("usersInGroups", $usersInGroups);
    
        $response->SetTemplate("editarOrles.php");
    
        return $response;
    } 
    
    


public function createNewOrla($request, $response, $container)
{
    $dbConfig = $container["config"]["database"];
    $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
    $connection = $dbModel->getConnection();

    $OrlaModel = new Orles($connection);
    $OrlaModel->createNewOrla();
    $userId = $_SESSION["user_id"];
    $orla = $OrlaModel->getOrles($userId);

         // Pasa los datos a la vista
        $response->set("orles", $orla);



        $response->SetTemplate("vieworles.php");
    return $response;
}


public function eliminarOrla($request, $response, $container)
{
    $orla_id = $_GET['id']; // Obtener el ID de la orla desde la URL

    $dbConfig = $container["config"]["database"];
    $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
    $connection = $dbModel->getConnection();

    $OrlaModel = new Orles($connection);
    $OrlaModel->eliminarOrla($orla_id);
    $userId = $_SESSION["user_id"];
    $orla = $OrlaModel->getOrles($userId);

    $response->set("orles", $orla);

    $response->SetTemplate("vieworles.php");
    return $response;
}

public function eliminarOrlaPanel($request, $response, $container)
{
    $orla_id = $_GET['id']; // Obtener el ID de la orla desde la URL

    $dbConfig = $container["config"]["database"];
    $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
    $connection = $dbModel->getConnection();

    $OrlaModel = new Orles($connection);
    $OrlaModel->eliminarOrla($orla_id);
    $userId = $_SESSION["user_id"];

    $response->SetTemplate("paneldecontrol.php");
    return $response;
}




/**
 * [add_users_to_orla description]
 *
 * @param   [type]  $request    [$request description]
 * @param   [type]  $response   [$response description]
 * @param   [type]  $container  [$container description]
 *
 * @return  [type]              [return description]
 */
public function add_users_to_orla($request, $response, $container)
{
    // Obtener el ID de la orla y los usuarios seleccionados del formulario
    
    $orla_id = $_POST['orla_id'];
    $selected_users = $_POST['selected_users'];
   
    // Llamar a la función en el modelo para agregar usuarios a la orla
    $dbConfig = $container["config"]["database"];
    $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
    $connection = $dbModel->getConnection();

    $OrlaModel = new Orles($connection);
    $OrlaModel->addUsersToOrla($orla_id, $selected_users);
    $photos = $OrlaModel->getPhotosForOrla($orla_id);
    $response->set("photos", $photos);
    $response->set("orla_id", $orla_id);
    $orlaName = $OrlaModel->getOrlaName($orla_id);
    $response->set("orlaName", $orlaName);
    // Obtener la lista de usuarios y grupos
    $usersModel = new UsersPDO($connection);
    $users = $usersModel->getAllUsers();
    $groups = $usersModel->getAllGroups();

    // Pasar la lista de usuarios y grupos a la vista
    $response->set("users", $users);
    $response->set("groups", $groups);

    // Para cada grupo, obtener los usuarios del grupo
    $usersInGroups = [];
    foreach ($groups as $group) {
        $usersInGroup = $usersModel->getUsersInGroup($group['id']);
        $usersInGroups[$group['id']] = $usersInGroup;
    }

    // Pasar la lista de usuarios en grupos a la vista
    $response->set("usersInGroups", $usersInGroups);


    
    
    $response->SetTemplate("editarOrles.php");

    return $response;
}

public function publish_orla($request, $response, $container)
{
    $dbConfig = $container["config"]["database"];
    $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
    $connection = $dbModel->getConnection();

    $OrlaModel = new Orles($connection);

    $orlaId = 1;
    $isPublished = 'isPublished';

    $OrlaModel->publishOrla($orlaId, $isPublished);

    $response->SetTemplate("vieworles.php");
    return $response;
}
public function UploadOrla($request, $response, $container)
{
    $orla_id = $_POST['id'];
    $name_orla = $_POST['name'];
    $status = $_POST['status'];
    $url = $_POST['url'];
    $group_id = $_POST['group_id'];
    $group_name = $_POST['group_name'];

    $dbConfig = $container["config"]["database"];
    $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
    $connection = $dbModel->getConnection();

    $OrlaModel = new Orles($connection);
    $OrlaModel->UploadOrla($orla_id, $name_orla, $status, $url, $group_name);

    $response->SetTemplate("paneldecontrol.php");
    return $response;
  
}

public function eliminarPhoto($request, $response, $container)
{
    $photo_id = $_GET['id']; // Obtener el ID de la orla desde la URL

    $dbConfig = $container["config"]["database"];
    $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
    $connection = $dbModel->getConnection();

    $OrlaModel = new Orles($connection);
    $OrlaModel->eliminarPhoto($photo_id);
    $userId = $_SESSION["user_id"];

    $response->SetTemplate("paneldecontrol.php");
    return $response;
}

}