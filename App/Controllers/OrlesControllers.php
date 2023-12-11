<?php

namespace App\Controllers;

use TCPDF;
class OrlesControllers 
{

    public function orles($request, $response, $container)
    {

        $OrlaModel = $container["\App\Models\Orles"];
        $userId = $request->get("SESSION", "user_id");
        $photoModel = $container["\App\Models\usersPDO"];
        $photo = $photoModel->getUserSelectedPhoto($userId);


        
        $orla = $OrlaModel->getOrles($userId);

        $response->set("orles", $orla);
        $response->set("photo", $photo);


        $response->SetTemplate("vieworles.php");
        return $response;
    }


   

    public function editarOrles($request, $response, $container)
    {
        $userId = $_SESSION["user_id"];
        $orla_id = $_GET["id"];
        $OrlaModel = $container["\App\Models\Orles"];
        
        $photos = $OrlaModel->getPhotosForOrla($orla_id);
        $response->set("photos", $photos);
        $response->set("orla_id", $orla_id);
        $orlaName = $OrlaModel->getOrlaName($orla_id);
        $response->set("orlaName", $orlaName);
        $orlaStatus = $OrlaModel->getStatusOrla($orla_id);
        $response->set("orlaStatus", $orlaStatus);

        // Obtener la lista de usuarios y grupos
        $usersModel = $container["\App\Models\usersPDO"];
        $users = $usersModel->getAllUsers();
        $groups = $usersModel->getAllGroups();
    
        // Pasar la lista de usuarios y grupos a la vista
        $response->set("users", $users);
        $response->set("groups", $groups);
        

        $photoModel = $container["\App\Models\usersPDO"];

        $photo = $photoModel->getUserSelectedPhoto($userId);
        $response->set("photo", $photo);
        // Para cada grupo, obtener los usuarios del grupo
        $usersInGroups = [];
        foreach ($groups as $group) {
            $usersInGroup = $usersModel->getUsersInGroup($group['id']);
            $usersInGroups[$group['id']] = $usersInGroup;
        }

        $response->set("usersInGroups", $usersInGroups);
        $_SESSION["orla_id"] = $orla_id;
        $response->SetTemplate("editarOrles.php");
    
        return $response;
    } 
    
    


public function createNewOrla($request, $response, $container)
{
    $OrlaModel = $container["\App\Models\Orles"];
    $OrlaModel->createNewOrla();
    $userId = $_SESSION["user_id"];
    $orla = $OrlaModel->getOrles($userId);
    $response->set("orles", $orla);
    $response->SetTemplate("vieworles.php");
    return $response;
}


public function eliminarOrla($request, $response, $container)
{
    $orla_id = $_GET['id']; // Obtener el ID de la orla desde la URL
    $OrlaModel = $container["\App\Models\Orles"];
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
    $OrlaModel = $container["\App\Models\Orles"];
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
   

    $OrlaModel = $container["\App\Models\Orles"];
    $OrlaModel->addUsersToOrla($orla_id, $selected_users);
    $photos = $OrlaModel->getPhotosForOrla($orla_id);
    $response->set("photos", $photos);
    $response->set("orla_id", $orla_id);
    $orlaName = $OrlaModel->getOrlaName($orla_id);
    $response->set("orlaName", $orlaName);
 

    $usersModel = $container["\App\Models\usersPDO"];
    $users = $usersModel->getAllUsers();
    $groups = $usersModel->getAllGroups();

    $response->set("users", $users);
    $response->set("groups", $groups);
    $orlaStatus = $OrlaModel->getStatusOrla($orla_id);
        $response->set("orlaStatus", $orlaStatus);

    $usersInGroups = [];
    foreach ($groups as $group) {
        $usersInGroup = $usersModel->getUsersInGroup($group['id']);
        $usersInGroups[$group['id']] = $usersInGroup;
    }


    $response->set("usersInGroups", $usersInGroups);
    
    $response->SetTemplate("editarOrles.php");

    return $response;
}

public function publish_orla($request, $response, $container)
{
    $userId = $_SESSION["user_id"];
    $PhotoModel = $container["\App\Models\Orles"];
    $OrlaModel = $container["\App\Models\Orles"];
    $orlaId = $_SESSION["orla_id"] ;
    $isPublished = 'isPublished';
    $OrlaModel->publishOrla($orlaId, $isPublished);
    $photos = $PhotoModel->getUserSelectedPhoto($userId);

    $response->set("photos", $photos);
    $response->SetTemplate("vieworles.php");

    return $response;
}

public function UploadOrla($request, $response, $container)
{
    $userId = $_SESSION["user_id"];
    $orla_id = $_POST['id'];
    $name_orla = $_POST['name'];
    $status = $_POST['status'];
    $url = $_POST['url'];

    $group_name = $_POST['group_name'];

    $OrlaModel = $container["\App\Models\Orles"];
    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];


    $grupsModel = $container["\App\Models\usersPDO"];
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $OrlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
 
    $photo = $photoModel->getUserSelectedPhoto($userId);

    $OrlaModel->UploadOrla($orla_id, $name_orla, $status, $url, $group_name);
    
    



    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    
    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);

    

    $response->SetTemplate("paneldecontrol.php");
    return $response;
  
}

public function eliminarPhoto($request, $response, $container)
{
    $photo_id = $_GET['id']; // Obtener el ID de la orla desde la URL
    $OrlaModel = $container["\App\Models\Orles"];
    $OrlaModel->eliminarPhoto($photo_id);
    $userId = $_SESSION["user_id"];
    $response->SetTemplate("paneldecontrol.php");
    return $response;
}






public function descarregarOrla($request, $response, $container)
{
    $orla_id = $request->getParam("id");

    $OrlaModel = $container["\App\Models\Orles"];
    $orlaData = $OrlaModel->getOrlaById($orla_id);

    $pdf = new TCPDF();

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Orla PDF');
    $pdf->SetSubject('Orla Data');

    $pdf->AddPage();

    $pdf->SetPageOrientation('L');

    $pdf->SetFont('times', '', 20);

    $html = '<h1 style="color: #000000; font-size: 24pt; text-align: center;">' . $orlaData['name_orla'] . '</h1>';

    $html .= '<p>Descripción: ' . "aa" . '</p>';
    $photoModel = $container["\App\Models\Orles"];
    $photos = $photoModel->getPhotosForOrla($orla_id);
    
    // Agregar imágenes con dimensiones específicas y sus nombres
    foreach ($photos as $photo) {
        $html .= '<div style="text-align: center;">';
        $html .= '<img src="' . $photo['url'] . '" alt="' . $photo['name'] . '" style="width: 50px; height: 50px; margin-right: 5px;">';
        $html .= '<p>' . $photo['name'] . '</p>';
        $html .= '</div>';
    }

    $pdf->SetFillColor(255, 255, 255); // Blanco
    $pdf->SetTextColor(0, 0, 0); // Negro

    // Imprimir HTML
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdfContent = $pdf->Output('S');

    $response = $response->withHeader('Content-Type', 'application/pdf');
    $response = $response->withHeader('Content-Disposition', 'attachment; filename="orla.pdf"');

    $response->getBody()->write($pdfContent);

    return $response;
}

















}