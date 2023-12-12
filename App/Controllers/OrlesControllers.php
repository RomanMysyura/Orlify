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

    // Configurar una imagen de fondo
    $pdf->SetWatermarkImage('./img/marco.svg');
    $pdf->showWatermarkImage = true;

    // Agregar página con orientación horizontal
    $pdf->AddPageByArray([
        'orientation' => 'L'
    ]);

    $pdf->SetFont('times', '', 20);

    // Obtener las fotos
    $photoModel = $container["\App\Models\Orles"];
    $photos = $photoModel->getPhotosForOrla($orla_id);

    // Configurar los encabezados de la respuesta
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="orla.pdf"');

    // Iniciar el contenido HTML
    $html = '<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; text-align: center;">';

    $html .= '<header style="background-color: rgba(255, 255, 255, 0);  padding: 2px;">';
    $html .= '<h1 style="color: #000000; font-size: 24pt; text-align: center; font-style: italic;">' . $orlaData['name_orla'] . '</h1>';
    $html .= '</header>';
    $html .= '<div style="margin: 0px; display: flex; justify-content: center; text-align: center;" class="">';
    $html .= '<h6 style="color: #000000; font-size: 10pt; text-align: center; "> Institut Cendrassos - Promoció 2023 - 2024 </h6>';
    $html .= '</div>';

    $html .= '<div style="margin-left: 8px; margin-right: 8px; border-radius: 5px; display: flex; justify-content: center; text-align: center;" class="container">';
    $html .= '<div style="display: flex; flex-wrap: wrap;">';

    $columnCount = 0; // Contador para rastrear el número de columnas en la fila actual

    $html .= '<div>';
    $html .= '<h5 style="text-align: center;">Professors</h5>';
    $html .= '</div>';

    foreach ($photos as $photo) {
        if ($photo['role'] == 'Professor') {
            // Determinar el estilo de la columna
            $columnStyle = 'float:left; width: 120px; height: 150px; border-radius: 5px; margin-top: 0;';

            // Calcular el margen izquierdo proporcional al número de fotos por línea

            // Agregar la columna al HTML con margen izquierdo
            $html .= '<div style="' . $columnStyle . '">';
            $html .= '<img src="' . $photo['url'] . '" alt="' . $photo['user_name'] . '" style="width: 100px; height: 130px; margin: 10px; border-radius: 5px;">';
            $html .= '<p style="margin-top: 3px; text-align: center; font-size: 12px;">' . $photo['user_name'] . " " . $photo['surname'] . '</p>';
            $html .= '</div>';

            // Aumentar el contador de columnas
            $columnCount++;

            // Si el contador es igual a 7, restablecerlo y agregar un estilo para bajar a la siguiente fila
            if ($columnCount == 7) {
                $columnCount = 0;
                $columnStyle .= 'clear: both;';
            }
        }
    }

    $html .= '<div style="clear: both;"></div>';

    $html .= '<div>';
    $html .= '<h5 style="text-align: center;"> Alumnes </h5>';
    $html .= '</div>';

    foreach ($photos as $photo) {
        if ($photo['role'] == 'Alumne') {
            // Determinar el estilo de la columna
            $columnStyle = 'float:left; width: 120px; height: 150px; border-radius: 5px; margin-top: 0;';

            // Calcular el margen izquierdo proporcional al número de fotos por línea

            // Agregar la columna al HTML con margen izquierdo
            $html .= '<div style="' . $columnStyle . '">';
            $html .= '<img src="' . $photo['url'] . '" alt="' . $photo['user_name'] . '" style="width: 100px; height: 130px; margin: 10px; border-radius: 10px;">';
            $html .= '<p style="margin-top: 3px; text-align: center; font-size: 12px;">' . $photo['user_name'] . " " . $photo['surname'] . '</p>';
            $html .= '</div>';

            // Aumentar el contador de columnas
            $columnCount++;

            // Si el contador es igual a 10, restablecerlo y agregar un estilo para bajar a la siguiente fila
            if ($columnCount == 10) {
                $columnCount = 0;
                $columnStyle .= 'clear: both;';
            }
        }
    }

    $html .= '</div>';
    $html .= '</div>';

    $html .= '</body>';

    // Imprimir HTML
    $pdf->WriteHTML($html);

    // Obtener el contenido del PDF como una cadena
    $pdfContent = $pdf->Output('', 'S');

    // Escribir el contenido del PDF en la salida
    echo $pdfContent;
}



public function updateNameOrla ($request, $response, $container)
{
    $userId = $_SESSION["user_id"];
        $Id_Orla = $_POST["id_orla"];
        $name_orla = $_POST["nom"];
        $OrlaModel = $container["\App\Models\Orles"];
        $OrlaNameModel = $container["\App\Models\Orles"];
        
        $photos = $OrlaModel->getPhotosForOrla($Id_Orla);
        $response->set("photos", $photos);
        $response->set("orla_id", $Id_Orla);
        
        $orlaStatus = $OrlaModel->getStatusOrla($Id_Orla);
        $response->set("orlaStatus", $orlaStatus);
        $Id_Orla_Name = $OrlaNameModel->UploadNameOrla($Id_Orla, $name_orla);
        $orlaName = $OrlaModel->getOrlaName($Id_Orla);
        $response->set("orlaName", $orlaName);

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
        $_SESSION["Id_Orla"] = $Id_Orla;
        $response->SetTemplate("editarOrles.php");
    
        return $response;
}
}