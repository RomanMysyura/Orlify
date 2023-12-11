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

    // Utilizar la clase \Mpdf\Mpdf
    $pdf = new \Mpdf\Mpdf();

    // Opciones del PDF
    $pdf->SetCreator('Your Name');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Orla PDF');
    $pdf->SetSubject('Orla Data');

    // Agregar página con orientación horizontal
    $pdf->AddPageByArray([
        'orientation' => 'L'
    ]);

    $pdf->SetFont('times', '', 20);

  

$html .= '<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">';

$html .= '<header style="background-color: #000000; color: #fff; text-align: center; padding: 2px;">';
$html .= '<h1 style="color: #ffffff; font-size: 24pt; text-align: center;">'. $orlaData['name_orla'] .'</h1>';
$html .= '</header>';

$html .= '<div style="margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 5px; display: flex; justify-content: center;" class="container">';
$html .= '<div style="display: flex; flex-wrap: wrap;">';

$photoModel = $container["\App\Models\Orles"];
$photos = $photoModel->getPhotosForOrla($orla_id);

foreach ($photos as $photo) {
  
    $html .= '<img src="' . $photo['url'] . '" alt="' . $photo['name'] . '" style="width: 100px; height: 130px; margin: 10px; border-radius: 5px;">';

}

$html .= '</div>';
$html .= '</div>';


$html .= '</body>';
   

    // Imprimir HTML
    $pdf->WriteHTML($html);

    // Obtener el contenido del PDF como una cadena
    $pdfContent = $pdf->Output('', 'S');

    // Configurar los encabezados de la respuesta
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="orla.pdf"');

    // Escribir el contenido del PDF en la salida
    echo $pdfContent;
}

















}