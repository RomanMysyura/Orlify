<?php

namespace App\Controllers;

use App\Models\Db;
use App\Models\UsersPDO;
use App\Models\Orles;
class OrlesControllers 
{

    public function orles($request, $response, $container)
    {

        //     // Obtén la conexión a la base de datos
        $dbConfig = $container["config"]["database"];
       $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        //     // Crea una instancia del modelo UsersPDO
          $OrlaModel = new Orles($connection);

        //     // Obtén los datos del usuario actual
        $userId = $_SESSION["user_id"];


        $orla = $OrlaModel->getOrles($userId);

         // Pasa los datos a la vista
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


        $response->SetTemplate("editarOrles.php");

        return $response;
}
}