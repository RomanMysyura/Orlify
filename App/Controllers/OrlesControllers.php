<?php
namespace App\Controllers;
class OrlesControllers 
{

    /**
     * Funció per gestionar la visualització de les orles per professor.
     *
     *
     * @return  [type]              Resposta amb les dades de les orles
     */
    public function orles($request, $response, $container)
    {
        $OrlaModel = $container["\App\Models\Orles"];
        $photoModel = $container["\App\Models\usersPDO"];
        $usersModel = $container["\App\Models\usersPDO"];
        $userId = $request->get("SESSION", "user_id");

        $photo = $photoModel->getUserSelectedPhoto($userId);
        $grupsprof = $usersModel->getGroupsProf($userId);
        $_SESSION["grup_prof"] = $grupsprof;
        $orla = $OrlaModel->getOrles($userId);

        $response->set("orles", $orla);
        $response->set("photo", $photo);
        $response->SetTemplate("vieworles.php");
        return $response;
    }




    /**
     * mevesOrles Funció visualitzar les orles de l'alumne actual.
     *
     *
     * @return  [type]              Resposta amb les dades de les orles del alumne
     */
    public function mevesOrles($request, $response, $container)
    {
        $OrlaModel = $container["\App\Models\Orles"];
        $photoModel = $container["\App\Models\usersPDO"];
        $usersModel = $container["\App\Models\usersPDO"];
    
        $userId = $request->get("SESSION", "user_id");
        $photo = $photoModel->getUserSelectedPhoto($userId);
    
        $grupsprof = $usersModel->getGroupsProf($userId);
        $_SESSION["grup_prof"] = $grupsprof;
    
        $orla = $OrlaModel->getOrles($userId);
    
        $response->set("orles", $orla);
        $response->set("photo", $photo);
    
        $response->SetTemplate("viewmevesorles.php");
        return $response;
    }
    

   


    /**
     * [editarOrles Funció per editar les orles]
     * @return  [type]              [return description]
     */
    public function editarOrles($request, $response, $container)
    {
        // Obtenir l'ID de l'usuari i l'ID de l'orla
        $userId = $_SESSION["user_id"];
        $orla_id = $_GET["id"];
    
        // Obtenir instàncies dels models necessaris
        $OrlaModel = $container["\App\Models\Orles"];
        $usersModel = $container["\App\Models\usersPDO"];
        $photoModel = $container["\App\Models\usersPDO"];
    
        // Obtenir fotos i usuaris a l'orla
        $photos = $OrlaModel->getPhotosForOrla($orla_id);
        $usersInOrla = $OrlaModel->getUsersInOrla($orla_id);
        $_SESSION["orla_users_ids"] = array_column($usersInOrla, 'user_id');
    
        // Configurar dades per a la resposta
        $response->set("photos", $photos);
        $response->set("orla_id", $orla_id);
        $response->set("orlaName", $OrlaModel->getOrlaName($orla_id));
        $response->set("orlaStatus", $OrlaModel->getStatusOrla($orla_id));
    
        // Obtenir la llista d'usuaris i grups
        $users = $usersModel->getAllUsers();
        $groups = $usersModel->getAllGroups();
        $grupsprof = $usersModel->getGroupsProf($userId);
        $_SESSION["grup_prof"] = $grupsprof;
    
        // Passar la llista d'usuaris i grups a la vista
        $response->set("users", $users);
        $response->set("groups", $groups);
    
        // Obtenir la foto seleccionada per l'usuari
        $photo = $photoModel->getUserSelectedPhoto($userId);
        $response->set("photo", $photo);
    
        // Obtenir usuaris en grups
        $usersInGroups = [];
        foreach ($groups as $group) {
            $usersInGroup = $usersModel->getUsersInGroup($group['id']);
            $usersInGroups[$group['id']] = $usersInGroup;
        }
        $response->set("usersInGroups", $usersInGroups);
    
        // Configurar sessió i plantilla de resposta
        $_SESSION["orla_id"] = $orla_id;
        $response->SetTemplate("editarOrles.php");
    
        return $response;
    }
    
    

    
    
/**
 * Funció per crear una nova orla
 * @param   [type]  $request    [$request description]
 * 
  */

public function createNewOrla($request, $response, $container)
{
    $OrlaModel = $container["\App\Models\Orles"];
    $OrlaModel->createNewOrla(); // Crear una nova orla
    $userId = $_SESSION["user_id"];
    $orla = $OrlaModel->getOrles($userId); // Obtenir les orles de l'usuari

    // Configurar la resposta
    $response->set("orles", $orla);
    $response->SetTemplate("vieworles.php");
    return $response;
}


/**
 * Funció per eliminar una orla
 * @param   [type]  $request    [$request description]
 * 
  */

public function eliminarOrla($request, $response, $container)
{
    $orla_id = $_GET['id']; // Obtenir l'ID de la orla desde la URL
    $OrlaModel = $container["\App\Models\Orles"];
    $OrlaModel->eliminarOrla($orla_id); // Eliminar l'orla
    $userId = $_SESSION["user_id"];
    $orla = $OrlaModel->getOrles($userId); // Obtenir les orles del usuari

    // Configurar la resposta
    $response->set("orles", $orla);
    $response->SetTemplate("vieworles.php");
    return $response;
}


/**
 * Funció per eliminar una orla des del panell de control
 * @param   [type]  $request    [$request description]
 * 
  */
public function eliminarOrlaPanel($request, $response, $container)
{
    $orla_id = $_GET['id']; // Obtenir l'ID de la orla desde la URL
    $OrlaModel = $container["\App\Models\Orles"];
    $OrlaModel->eliminarOrla($orla_id); // Eliminar l'orla
    $userId = $_SESSION["user_id"]; // Obtenir l'ID de l'usuari

    $response->SetTemplate("paneldecontrol.php");
    return $response;
}

/**
 * Afegeix usuaris a una orla
 *
 * @param   [type]  $request    [$request descripció]
 * @param   [type]  $response   [$response descripció]
 * @param   [type]  $container  [$container descripció]
 *
 * @return  [type]              [return descripció]
 */
public function add_users_to_orla($request, $response, $container)
{
    // Obté l'ID de l'orla i els usuaris seleccionats del formulari
    $orla_id = $_POST['orla_id'];
    $selected_users = $_POST['selected_users'];

    $OrlaModel = $container["\App\Models\Orles"];
    
    // Afegeix els usuaris a l'orla
    $OrlaModel->addUsersToOrla($orla_id, $selected_users);
    
    // Obté les fotos per a l'orla
    $photos = $OrlaModel->getPhotosForOrla($orla_id);
    $response->set("photos", $photos);
    
    // Configura les dades per a la resposta
    $response->set("orla_id", $orla_id);
    $orlaName = $OrlaModel->getOrlaName($orla_id);
    $response->set("orlaName", $orlaName);
 
    // Obté els usuaris a l'orla i configura la sessió
    $usersInOrla = $OrlaModel->getUsersInOrla($orla_id);
    $_SESSION["orla_users_ids"] = array_column($usersInOrla, 'user_id');

    // Obté les instàncies del model d'usuaris
    $usersModel = $container["\App\Models\usersPDO"];
    $users = $usersModel->getAllUsers();
    $groups = $usersModel->getAllGroups();

    // Configura la resposta amb usuaris i grups
    $response->set("users", $users);
    $response->set("groups", $groups);
    
    // Obté l'estat de l'orla i configura la resposta
    $orlaStatus = $OrlaModel->getStatusOrla($orla_id);
    $response->set("orlaStatus", $orlaStatus);

    // Obté els usuaris als grups
    $usersInGroups = [];
    foreach ($groups as $group) {
        $usersInGroup = $usersModel->getUsersInGroup($group['id']);
        $usersInGroups[$group['id']] = $usersInGroup;
    }

    // Configura la resposta amb els usuaris als grups
    $response->set("usersInGroups", $usersInGroups);
    
    // Configura la plantilla de resposta
    $response->SetTemplate("editarOrles.php");

    return $response;
}


/**
 * Funció per publicar una orla
 * @param   [type]  $request    [$request descripció]
 */
public function publish_orla($request, $response, $container)
{
    $userId = $_SESSION["user_id"];
    $PhotoModel = $container["\App\Models\Orles"];
    $OrlaModel = $container["\App\Models\Orles"];
    $orlaId = $_SESSION["orla_id"];
    $isPublished = 'isPublished';

    // Publica l'orla amb l'ID corresponent
    $OrlaModel->publishOrla($orlaId, $isPublished);

    // Obté les fotos seleccionades per a l'usuari
    $photos = $PhotoModel->getUserSelectedPhoto($userId);

    // Configura la resposta amb les fotos i la plantilla
    $response->set("photos", $photos);
    $response->SetTemplate("vieworles.php");

    return $response;
}

/**
 * Funció per editar una orla
 *
 * @param   [type]  $request     [$request descripció]
 * @param   [type]  $response    [$response descripció]
 * @param   [type]  $container   [$container descripció]
 *
 * @return  [type]               [return descripció]
 */
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

    // Actualitzar la informació de l'orla amb les dades proporcionades
    $OrlaModel->UploadOrla($orla_id, $name_orla, $status, $url, $group_name);

    // Obtindre les dades necessàries per poder obtenir tota la informació del panell de control
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $OrlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
    $photo = $photoModel->getUserSelectedPhoto($userId);

    // Assignar fotos i grups als usuaris
    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    // Assignar usuaris als grups
    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    // Configurar la resposta amb les dades obtingudes
    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);

    // Configurar la plantilla de resposta
    $response->SetTemplate("paneldecontrol.php");

    return $response;
}


/**
 * Funció per eliminar una foto
 *
 * @param   [type]  $request     [$request descripció]
 * @param   [type]  $response    [$response descripció]
 * @param   [type]  $container   [$container descripció]
 *
 * @return  [type]               [return descripció]
 */
public function eliminarPhoto($request, $response, $container)
{
    $photo_id = $_GET['id']; // Obté l'ID de la foto des de la URL
    $userId = $_SESSION["user_id"];
    $OrlaModel = $container["\App\Models\Orles"];
    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];
    $grupsModel = $container["\App\Models\usersPDO"];

    // Obté les dades necessàries per poder obtenir tota la informació del panell de control
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $OrlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
    $photo = $photoModel->getUserSelectedPhoto($userId);

    // Elimina la foto amb l'ID corresponent
    $OrlaModel->eliminarPhoto($photo_id);

    // Assigna fotos i grups als usuaris
    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    // Assigna usuaris als grups
    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    // Configura la resposta amb les dades obtingudes
    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);

    // Configura la plantilla de resposta
    $response->SetTemplate("paneldecontrol.php");

    return $response;
}


/**
 * Funció per descarregar una orla en format pdf
 *
 * @param   [type]  $request             [$request descripció]
 * @param   [type]  $response            [$response descripció]
 * @param   [type]  $container           [$container descripció]
 *
 * @return  [type]                       [return descripció]
 */
public function descarregarOrla($request, $response, $container)
{
    // Obtenir l'ID de l'orla
    $orla_id = $request->getParam("id");

    // Obtenir el format de la impressió, per defecte A4
    $formato_impresion = $request->getParam("formato_impresion", "A4");

    $OrlaModel = $container["\App\Models\Orles"];
    $orlaData = $OrlaModel->getOrlaById($orla_id); // Obtenir les dades de l'orla

    // Utilitzar la llibreria mPDF per generar el PDF, amb el format corresponent al paràmetre
    $pdf = new \Mpdf\Mpdf(['format' => $formato_impresion]);

    // Opcions de configuració del PDF
    $pdf->SetCreator('Your Name');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Orla PDF');
    $pdf->SetSubject('Orla Data');

    // Configurar una imagtge de fons
    $pdf->SetWatermarkImage('./img/marco.svg');
    $pdf->showWatermarkImage = true;

    // Afegeix una pàgina al PDF horitzontalment
    $pdf->AddPageByArray([
        'orientation' => 'L'
    ]);

    // Configurar la font
    $pdf->SetFont('times', '', 20);

    // Obtenir les fotos de l'orla
    $photoModel = $container["\App\Models\Orles"];
    $photos = $photoModel->getPhotosForOrla($orla_id);

    // Configurar la capçalera HTTP per descarregar el PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="orla.pdf"');

    // Configurar les variables per a cada format de impressió
    if ($formato_impresion === 'A4') {
        $columnStyleBase = 'float:left; width: 120px; height: 150px; border-radius: 5px; margin-top: 0;';
        $imageWidth = 80;
        $imageHeight = 100;
        $columnCountLimit = 8;
        $headerSize = 24;
        $headerMarginTop = 2;
        $NameSize = 12;
        $ColumnMarginLeft = 10;
    } elseif ($formato_impresion === 'A3') {
        $columnStyleBase = 'float:left; width: 160px; height: 200px; border-radius: 5px; margin-top: 0;';
        $imageWidth = 120;
        $imageHeight = 150;
        $columnCountLimit = 8;
        $headerSize = 32;
        $headerMarginTop = 26;
        $NameSize = 16;
        $ColumnMarginLeft = 50;
    } elseif ($formato_impresion === 'A2') {
        $columnStyleBase = 'float:left; width: 190px; height: 250px; border-radius: 5px; margin-top: 0;';
        $imageWidth = 150;
        $imageHeight = 190;
        $columnCountLimit = 7;
        $headerSize = 48;
        $headerMarginTop = 125;
        $NameSize = 24;
        $ColumnMarginLeft = 220;
    }

    // Iniciar el contingut HTML
    $html = '<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; text-align: center;">';

    $html .= '<header style="background-color: rgba(255, 255, 255, 0);  padding: ' . $headerMarginTop . 'px;">';
    $html .= '<h1 style="color: #000000; font-size: ' . $headerSize . 'pt; text-align: center; font-style: italic;">' . $orlaData['name_orla'] . '</h1>';
    $html .= '</header>';

    $html .= '<div style="margin-left: ' . $ColumnMarginLeft . 'px; margin-right: 8px; border-radius: 5px; display: flex; justify-content: center; text-align: center;" class="container">';
    $html .= '<div style="display: flex; flex-wrap: wrap;">';

    $columnCount = 0; // Contador de columnes

    foreach ($photos as $photo) {
        if ($photo['role'] == 'Professor') {
            // Determinar l'estil de la columna
            $columnStyle = $columnStyleBase;


            // Afegeix la columna al HTML amb el marge esquerre
            $html .= '<div style="' . $columnStyle . '">';
            $html .= '<img src="' . $photo['url'] . '" alt="' . $photo['user_name'] . '" style="width: ' . $imageWidth . 'px; height: ' . $imageHeight . 'px; margin: 5px; border-radius: 5px;">';
            $html .= '<p style="margin-top: 3px; text-align: center; font-size: ' . $NameSize . 'px;">' . $photo['user_name'] . " " . $photo['surname'] . '</p>';
            $html .= '</div>';
    

            // Augmentar el contador de columnes
            $columnCount++;

            // Si el contador es igual a 10, restablir-lo i afegir un estil per baixar a la següent fila
            if ($columnCount == $columnCountLimit) {
                $columnCount = 0;
                $columnStyle .= 'clear: both;';
            }
        }
    }

    $html .= '<div style="clear: both;"></div>';

    $html .= '<div style="margin: 0px; display: flex; justify-content: center; text-align: center;" class="">';
    $html .= '<h6 style="color: #000000; font-size: ' . $NameSize . 'px; text-align: center; "> Institut Cendrassos - Promoció 2023-2024 </h6>';
    $html .= '</div>';

    foreach ($photos as $photo) {
        if ($photo['role'] == 'Alumne') {
            // Determinar l'estil de la columna
            $columnStyle = $columnStyleBase;
            

            // Afegeix la columna al HTML amb el marge esquerre
            $html .= '<div style="' . $columnStyle . '">';
            $html .= '<img src="' . $photo['url'] . '" alt="' . $photo['user_name'] . '" style="width: ' . $imageWidth . 'px; height: ' . $imageHeight . 'px; margin: 5px; border-radius: 5px;">';
            $html .= '<p style="margin-top: 3px; text-align: center; font-size: ' . $NameSize . 'px;">' . $photo['user_name'] . " " . $photo['surname'] . '</p>';
            $html .= '</div>';

            //  Augmentar el contador de columnes
            $columnCount++;

            // Si el contador es igual a 10, restablir-lo i afegir un estil per baixar a la següent fila
            if ($columnCount == $columnCountLimit) {
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

    // Obtenir el contingut del PDF
    $pdfContent = $pdf->Output('', 'S');

    // Escriure el contingut del PDF
    echo $pdfContent;
}




/**
 * Funció per editar el nom d'una orla
 *
 * @param   [type]  $request     [$request descripció]
 * @param   [type]  $response    [$response descripció]
 * @param   [type]  $container   [$container descripció]
 *
 * @return  [type]               [return descripció]
 */
public function updateNameOrla ($request, $response, $container)
{
        $userId = $_SESSION["user_id"]; // Obtenir l'ID de l'usuari
        $Id_Orla = $_POST["id_orla"]; // Obtenir l'ID de l'orla
        $name_orla = $_POST["nom"]; // Obtenir el nom de l'orla
        $OrlaModel = $container["\App\Models\Orles"];
        $OrlaNameModel = $container["\App\Models\Orles"];
        
        $photos = $OrlaModel->getPhotosForOrla($Id_Orla); // Obtenir les fotos de l'orla
        $response->set("photos", $photos);
        $response->set("orla_id", $Id_Orla);
        
        $orlaStatus = $OrlaModel->getStatusOrla($Id_Orla); // Obtenir l'estat de l'orla
        $response->set("orlaStatus", $orlaStatus);
        $Id_Orla_Name = $OrlaNameModel->UploadNameOrla($Id_Orla, $name_orla); // Actualitzar el nom de l'orla
        $orlaName = $OrlaModel->getOrlaName($Id_Orla); // Obtenir el nom de l'orla
        $response->set("orlaName", $orlaName);

        // Obtenir les instàncies del model d'usuaris
        $usersModel = $container["\App\Models\usersPDO"];
        $users = $usersModel->getAllUsers();
        $groups = $usersModel->getAllGroups();
    
        // Configurar la resposta amb usuaris i grups
        $response->set("users", $users);
        $response->set("groups", $groups);
        

        $photoModel = $container["\App\Models\usersPDO"];

        $photo = $photoModel->getUserSelectedPhoto($userId);
        $response->set("photo", $photo);
        // Obtenir usuaris en grups
        $usersInGroups = [];
        foreach ($groups as $group) {
            $usersInGroup = $usersModel->getUsersInGroup($group['id']);
            $usersInGroups[$group['id']] = $usersInGroup;
        }

        $response->set("usersInGroups", $usersInGroups);
        $_SESSION["Id_Orla"] = $Id_Orla;
        $response->SetTemplate("editarOrles.php");
        // Configurar la plantilla de resposta
        return $response;
}
}