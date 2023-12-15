<?php

namespace App\Controllers;

class UserController
{

    public function index($request, $response, $container)
    {
        $userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0;
    
        $usersModel = $container["\App\Models\usersPDO"];
        $photoModel = $container["\App\Models\usersPDO"];
        $photo = $photoModel->getUserSelectedPhoto($userId);
        $users = $usersModel->getAllUsers();
    
        $response->set("users", $users);
        $response->set("photo", $photo);
        $response->SetTemplate("index.php");
        return $response;
    }
    



    public function perfil($request, $response, $container)
    {
        // Verifica si el usuario está autenticado
        if ($_SESSION["logged"]) {
            
            // Crea una instancia del modelo UsersPDO
            $usersModel = $container["\App\Models\usersPDO"];
            $userPhoto = $container["\App\Models\usersPDO"];
            $photoModel = $container["\App\Models\usersPDO"];
            

            // Obtén los datos del usuario actual
            $userId = $_SESSION["user_id"];
            $user = $usersModel->getUserById($userId);
            $userPhoto = $usersModel->getUserSelectedPhoto($userId);
            $photo = $photoModel->getUserSelectedPhoto($userId);

            // Pasa los datos a la vista
            $response->set("user", $user);
            $response->set("userPhoto", $userPhoto);

            // Llama al método del modelo para obtener el grupo
            $group = $usersModel->getGroupForUser($userId);

            // Pasa los datos a la vista
            $response->set("user", $user);
            $response->set("group", $group);
            $response->set("photo", $photo);

            // Establece la plantilla
            $response->SetTemplate("perfil.php");
        } else {
            // Si no está autenticado, redirige a la página de inicio de sesión u otra página
            $response->redirect("/login");
        }

        return $response;
    }




    public function login($request, $response, $container)
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        $usersModel = $container["\App\Models\usersPDO"];
        
         
    
        $loggedInUser = $usersModel->login($email, $password);
    
        if ($loggedInUser) {
            $_SESSION["user_id"] = $loggedInUser["id"];
            $_SESSION["group_id"] = $loggedInUser["group_id"];
            $_SESSION["logged"] = true;
            $_SESSION["role"] = $loggedInUser["role"];
    
            $userId = $_SESSION["user_id"];
            $photoModel = $container["\App\Models\usersPDO"];
           
            $group = $usersModel->getGroupForUser($userId);
            $user = $usersModel->getUserById($userId);
            $userPhoto = $usersModel->getUserSelectedPhoto($userId);
            $photo = $photoModel->getUserSelectedPhoto($userId);
    
            $response->set("user", $loggedInUser);
            $response->set("group", $group);
            $response->set("userPhoto", $userPhoto);
            $response->set("photo", $photo);
    
            $response->SetTemplate("perfil.php");
        } else {
            $response->SetTemplate("index.php");
            $response->set("error_message_login", "Email i/o contrasenya incorrectes");
            $_SESSION["logged"] = false;
        }
    
        return $response;
    }
    


    public function logout($request, $response, $container)
    {

        $_SESSION["logged"] = false;
        $response->SetTemplate("index.php");
        return $response;
    }


    public function register($request, $response, $container)
    {
        $usersModel = $container["\App\Models\usersPDO"];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["username"];
            $surname = $_POST["surname"];
            $email = $_POST["mail"];
            $phone = $_POST["phone"];
            $dni = $_POST["dni"];
            $birthDate = $_POST["birth_date"];
            $password = $_POST["password"];
            $groupId = $_POST["group"]; // Nuevo campo para obtener el grupo seleccionado

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $response->set("error_message_register", "La cuenta creada correctamente");
            $response->SetTemplate("index.php");

            // Registrar usuario y obtener el ID del nuevo usuario
            $userId = $usersModel->registerUser($name, $surname, $email, $phone, $dni, $birthDate, 'Alumne', $hashedPassword);

            // Asociar el usuario al grupo en la tabla user_groups
            $usersModel->assignUserToGroup($userId, $groupId);

    
              // Si no tiene un token, genera uno nuevo y guárdalo
                  // Genera un token único
                  $token = uniqid();
      
                  // Guarda el token en la base de datos
                  $usersModel->saveUserToken($userId, $token);

            return $response;
        }

        $response->SetTemplate("index.php");
        return $response;
    }

    public function randomuser($request, $response, $container)
    {

        $usersModel2 = $container["\App\Models\usersPDO"];
        $usersModel = $container["\App\Models\usersPDO"];
        $errorModel = $container["\App\Models\usersPDO"];
        $orlaModel = $container["\App\Models\Orles"];
        $grupsModel = $container["\App\Models\usersPDO"];
        $userId = $_SESSION["user_id"];
        $photoModel = $container["\App\Models\usersPDO"];
        $photo = $photoModel->getUserSelectedPhoto($userId);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["username"];
            $surname = $_POST["surname"];
            $email = $_POST["mail"];
            $birthDate = $_POST["birth_date"];
            $role = $_POST["role"];
            $password = $_POST["password"];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $response->set("error_message_register", "La conta creada correctament");
            $response->SetTemplate("paneldecontrol.php");
            $userId_random=$usersModel2->registerRandomUser($name, $surname, $email, $birthDate, $hashedPassword, $role);
            $token = uniqid();
      
            // Guarda el token en la base de datos
            $usersModel2->saveUserToken($userId_random, $token);
            $users = $usersModel->getAllUsers();
        $errors = $errorModel->geterror();
        $orles = $orlaModel->getAllOrles();
        $grups = $grupsModel->getAllGroups();
        foreach ($users as &$user) {
            $user["photos"] = $usersModel->getUserPhotos($user["id"]);
            $groups = $usersModel->getGroupByUserId($user["id"]);
        
            if ($groups !== null) {
                $user["groups"] = $groups;
            } else {
                $user["groups"] = 'Sense grup';
            }
        }
    
        foreach ($orles as &$orla) {
            $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
        }

        foreach ($grups as &$grup) {
            $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
        }


            return $response;
        }

       
    
        $response->set("users", $users);
        $response->set("errors", $errors);
        $response->set("orles", $orles);
        $response->set("grups", $grups);
        $response->set("photo", $photo);
    

        $response->SetTemplate("paneldecontrol.php");
        return $response;
    }


    public function uploadUser($request, $response, $container)
    {
        $usersModel = $container["\App\Models\usersPDO"];
        $photoModel = $container["\App\Models\usersPDO"];


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];

            $usersModel->editUser($id, $name, $surname, $email, $phone);

            header("Location: perfil");
            exit();
        }

        $id = $_POST["id"];
        $user = $usersModel->getUserById($id);
        $photo = $photoModel->getUserSelectedPhoto($id);

        $response->set("photo", $photo);
        $response->SetTemplate("perfil.php", ["user" => $user]);
        return $response;
    }

    public function uploadUserAdmin($request, $response, $container)
    {
        $userId = $_SESSION["user_id"];

        $usersModel = $container["\App\Models\usersPDO"];
        $errorModel = $container["\App\Models\usersPDO"];
        $orlaModel = $container["\App\Models\Orles"];
        $grupsModel = $container["\App\Models\usersPDO"];
        $photoModel = $container["\App\Models\usersPDO"];


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $dni = $_POST["dni"];
            $birth_date = $_POST["birth_date"];
            $group_name = $_POST["group"];
            $role = $_POST["role"];
            

            $usersModel->editUserAdmin($id, $name, $surname, $email, $phone, $dni, $birth_date, $group_name, $role);

       
        }

       
  
        
        $users = $usersModel->getAllUsers();
        $errors = $errorModel->geterror();
        $orles = $orlaModel->getAllOrles();
        $grups = $grupsModel->getAllGroups();
        $photo = $photoModel->getUserSelectedPhoto($UserId);

        foreach ($users as &$user) {
            $user["photos"] = $usersModel->getUserPhotos($user["id"]);
            $groups = $usersModel->getGroupByUserId($user["id"]);
        
            if ($groups !== null) {
                $user["groups"] = $groups;
            } else {
                $user["groups"] = 'Sense grup';
            }
        }
    
        foreach ($orles as &$orla) {
            $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
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
    public function carnetUser($request, $response, $container)
    {
        $id = $request->getParam("token");
    
        $usersModel = $container["\App\Models\usersPDO"];
        $photoModel = $container["\App\Models\usersPDO"];
        $photo = $photoModel->getUserSelectedPhoto($_SESSION["user_id"]);
        $response->set("photo", $photo);
    
        // Busca el usuario por el token
        $user = $usersModel->getUserByToken($id);
    
        // Verifica si el token existe en la base de datos
        if ($user) {
            // Si el usuario se encuentra por el token, obtén la información
            $group = $usersModel->getGroupForUser($user["id"]);
    
            // Pasa los datos a la vista
            $response->set("user", $user);
            $response->set("group", $group);
            $response->set("uniqueUrl", "/carnet/{$user["id"]}");
           
            // Establece la plantilla
            $response->setTemplate("carnet.php");
        } elseif (isset($_SESSION["user_id"])) {
            // Si no se encuentra el usuario por el token pero hay un usuario iniciado sesión, muestra su información
            $userId = $_SESSION["user_id"];
            $user = $usersModel->getUserById($userId);
    
            if ($user) {
                // Si el usuario se encuentra por la sesión, obtén la información
                $group = $usersModel->getGroupForUser($user["id"]);
    
                // Pasa los datos a la vista
                $response->set("user", $user);
                $response->set("group", $group);
                $response->set("uniqueUrl", "/carnet/{$user["id"]}");
               
                // Establece la plantilla
                $response->setTemplate("carnet.php");
            } else {
                // Si no se encuentra el usuario por la sesión, muestra un mensaje de error
                $response->set("error", "Usuario no encontrado");
                $response->setTemplate("error.php");
            }
        } else {
            // Si el token no coincide con ningún usuario y no hay token en la sesión, muestra un mensaje de error
            $response->set("error", "Acceso no autorizado");
            $response->setTemplate("error.php");
        }
    
        return $response;
    }
    
    
    
    
    

    public function photoUser($request, $response, $container)
    {

        $userId = $_SESSION["user_id"];
        $PhotoModel = $container["\App\Models\usersPDO"];

        $photo = $PhotoModel->getUserSelectedPhoto($userId);

        $usersModel = $container["\App\Models\usersPDO"];

        $photos = $usersModel->getUserPhotos($userId);

        $response->set("photos", $photos);
        $response->set("photo", $photo);
        $response->SetTemplate("photo.php");
        return $response;

    }


    public function uploadPhoto($request, $response, $container)
    {
        $userId = $_SESSION["user_id"];
    
        $UploadUserPhoto = $container["\App\Models\usersPDO"];
        $photoModel = $container["\App\Models\usersPDO"];
        $photo = $photoModel->getUserSelectedPhoto($userId);
    
        if (isset($_POST["selectedPhoto"])) {
            $selectedPhoto = $_POST["selectedPhoto"];
    
            // Desactivar todas las fotos del usuario
            $UploadUserPhoto->deactivateUserPhotos($userId);
    
            // Activar la foto seleccionada
            $UploadUserPhoto->activateSelectedPhoto($userId, $selectedPhoto);
    
            header("Location: perfil");
            exit();
        } else {
            echo 'error';
        }
    
        $response->set("photo", $photo);
        return $response;
    }
    

    public function cercador($request, $response, $container)
    {
        $userId = $_SESSION["user_id"];
        $alumnes = $container["\App\Models\usersPDO"];
        $alumnes = $alumnes->getAlumnesByProfessor($userId);
        $response->set("alumnes", $alumnes);
        $response->SetTemplate("cercador.php");
        return $response;
    }

    public function alumnes($request, $response, $container)
    {
        $userId = $_SESSION["user_id"];
        $photoModel = $container["\App\Models\usersPDO"];
     
        $alumnes = $container["\App\Models\usersPDO"];
        $alumnes = $alumnes->getAlumnesByProfessor($userId);
        $photo = $photoModel->getUserSelectedPhoto($userId);
        $response->set("alumnes", $alumnes);
        $response->set("photo", $photo);
        $response->SetTemplate("alumnes.php");

        return $response;
    }
    
    public function contactar($request, $response, $container)
    {

        $userId = $_SESSION["user_id"];
        $photoModel = $container["\App\Models\usersPDO"];
        $photo = $photoModel->getUserSelectedPhoto($userId);
        $response->set("photo", $photo);
         $response->SetTemplate("contactar.php");
        return $response;
 
    }

    public function enviarcontactar($request, $response, $container)
    {
        $userId = $_SESSION["user_id"];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $mensaje = $_POST["mensaje"];
        $email = $_POST["email"];

        $errorModel = $container["\App\Models\usersPDO"];
        $photoModel = $container["\App\Models\usersPDO"];
        $photo = $photoModel->getUserSelectedPhoto($userId);
        
        $Createerror = $errorModel->createerror($userId, $mensaje);
        $response->set("photo", $photo);
        $response->SetTemplate("contactar.php");
        return $response;
        } else {
            echo 'error';
        }
 
    }

   

  

    
    public function Idpanel($request, $response, $container)
    {
        $userId = $_SESSION["user_id"];
        $usersModel = $container["\App\Models\usersPDO"];

        $users = $usersModel->Idpanel($userId);

        $response->set("users", $users);
        $response->SetTemplate("paneldecontrol.php");
        return $response;

    }
    public function deleteUser($request, $response, $container)
    {
        $user_id = $_GET['id'];
        $userId = $_SESSION["user_id"];
    $OrlaModel = $container["\App\Models\Orles"];
    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];


    $grupsModel = $container["\App\Models\usersPDO"];
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $OrlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
 
    
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

   
        $usersModel = $container["\App\Models\usersPDO"];
        $usersModel->deleteUser($user_id);

        $response->set("users", $users);
        
        $response->set("errors", $errors);
        $response->set("orles", $orles);
        $response->set("grups", $grups);
        $response->set("photo", $photo);
    

        $response->SetTemplate("paneldecontrol.php");
        return $response;
    }

  public function deleteerror($request, $response, $container){
    $error_id = $_GET['id'];
    $errorrModel = $container["\App\Models\usersPDO"];
    $errorrModel->deleteerror($error_id);
    
    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];
    $userId = $_SESSION["user_id"];
    $photoModel = $container["\App\Models\usersPDO"];
    $photo = $photoModel->getUserSelectedPhoto($userId);

    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();

    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    foreach ($orles as &$orla) {
        $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
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

  public function uploaderror($request, $response, $container) {
    // Verifica si se están enviando los datos correctamente
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST["error_status"];
        $error_id = $_POST["id"];  // Cambiado a $_POST["id"]

        $errorModel = $container["\App\Models\usersPDO"];

        // Verifica si la función uploadError está implementada correctamente en UsersPDO
        $errorModel->uploadError($error_id, $status);
    } else {
        echo 'error';

    }

    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
    $photo = $photoModel->getUserSelectedPhoto($id);
    
    
    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    foreach ($orles as &$orla) {
        $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
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
 
public function uploadPhotoFromFile($request, $response, $container)
{
    
  
    if (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $tmpFilePath = $file['tmp_name'];

            $newFileName = uniqid('image_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

            $destinationPath = "img/" . $newFileName;

            if (move_uploaded_file($tmpFilePath, $destinationPath)) {
                $successMessage = '
                <div role="alert" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded z-50">
                      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                      <span>Has pujat i actualitzat la foto del alumne</span>
                    </div>
            ';

         
            echo $successMessage;

                $usersModel = $container["\App\Models\usersPDO"];
               
                $UploadUserPhoto = $container["\App\Models\usersPDO"];
                

                $user_id = $_POST['user_id']; 
                $userId = $_SESSION["user_id"];
                $UploadUserPhoto->deactivateUserPhotos($user_id);
                $usersModel->uploadPhotoFromFile($user_id, $destinationPath, 'active');
               
    
            } else {
                echo "Error al guardar la imagen.";
            }
        } else {
           echo '<div role="alert" class="fixed bottom-4 right-4 bg-amber-500 text-white px-4 py-2 rounded z-50 w-xs">
           <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
           <span>Atenció: Has de seleccionar una foto!</span>
         </div>';
        }
    } else {
        echo "No se ha enviado ninguna imagen.";
    }
    
    $userId = $_SESSION["user_id"];
    $photoModel = $container["\App\Models\usersPDO"];
   

    $alumnes = $container["\App\Models\usersPDO"];

    $alumnes = $alumnes->getAlumnesByProfessor($userId);
    $photo = $photoModel->getUserSelectedPhoto($userId);

    $response->set("alumnes", $alumnes);
    $response->set("photo", $photo);
    $response->SetTemplate("alumnes.php");
    
    return $response;
}
public function uploadPhotoFromFileEdit($request, $response, $container)
{
    // Asegúrate de que se ha enviado la información de la imagen en Base64
    if (isset($_POST['photo'])) {
        $base64Image = $_POST['photo'];

        // Decodificar la imagen Base64
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

        // Generar un nombre de archivo único
        $newFileName = uniqid('image_') . '.png';

        // Ruta de destino para guardar la imagen
        $destinationPath = "img/" . $newFileName;

        // Guardar la imagen en el servidor
        if (file_put_contents($destinationPath, $imageData)) {
            // Éxito al guardar la imagen
            $successMessage = '<div role="alert" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Has pujat i actualitzat la foto del alumne</span>
            </div>';

            echo $successMessage;

            // Resto del código para interactuar con la base de datos
            $usersModel = $container["\App\Models\usersPDO"];
            $UploadUserPhoto = $container["\App\Models\usersPDO"];

            $user_id = $_POST['user_id']; 
            $userId = $_SESSION["user_id"];
            $UploadUserPhoto->deactivateUserPhotos($user_id);
            $usersModel->uploadPhotoFromFile($user_id, $destinationPath, 'active');

        } else {
            echo "Error al guardar la imagen.";
        }
    } else {
        echo "No se ha enviado ninguna imagen.";
        var_dump($_POST);
    }

    // Resto del código para cargar datos y renderizar la plantilla
    $userId = $_SESSION["user_id"];
    $photoModel = $container["\App\Models\usersPDO"];
    $alumnes = $container["\App\Models\usersPDO"];
    $alumnes = $alumnes->getAlumnesByProfessor($userId);
    $photo = $photoModel->getUserSelectedPhoto($userId);

    $response->set("alumnes", $alumnes);
    $response->set("photo", $photo);
    $response->SetTemplate("alumnes.php");

    return $response;
}

public function DeleteGrup($request, $response, $container)
{
    $grup_id = $_GET['id'];


    $usersModel = $container["\App\Models\usersPDO"];
    $usersModel->DeleteGrup($grup_id);
    $userId = $_SESSION["user_id"];
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];
    $photo = $photoModel->getUserSelectedPhoto($userId);
   
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();

    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    foreach ($orles as &$orla) {
        $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
    }

    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);
    
    $response->set("users", $users);

    $response->SetTemplate("paneldecontrol.php");
    return $response;
}

public function crearGrup($request, $response, $container)
{  
    $name = $_POST["name"];

  

    $usersModel = $container["\App\Models\usersPDO"];
    $usersModel->crearGrup($name);
    $userId = $_SESSION["user_id"];
    $users = $usersModel->Idpanel($userId);

   
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
    
    
    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    foreach ($orles as &$orla) {
        $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
    }

    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);

    $response->set("users", $users);

    $response->SetTemplate("paneldecontrol.php");
    return $response;

}
public function sendRecoveryEmail($request, $response, $container) {
    $emailModel = $container["\App\Models\usersPDO"];

    // Verifica si el correo electrónico existe en tu lógica de aplicación
    $email = $_POST["email"]; // Asigna un valor a la variable $email
    if ($emailModel->emailExists($email)) {
        // Genera un token único
        $token = uniqid();

        // Almacena el token en la base de datos
        $emailModel->storeToken($email, $token);

        // Intenta enviar el correo electrónico de recuperación con el token
        try {
            $emailModel->RecoveryEmail($email, $token);

            // Se ha enviado un correo para recuperar la contraseña
            $response->SetTemplate("sendemail.php");
            return $response;

        } catch (\Exception $e) {
            // Manejar el error de manera segura (puede registrar en un archivo de registro)
            $response->SetTemplate("erroremail.php");
            return $response;
        }
    }

    // Si el correo no existe, redirige a la página de error
    $response->SetTemplate("erroremail.php");
    return $response;
}


public function newpass($request, $response, $container)
{
    $usersModel = $container["\App\Models\usersPDO"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Obtener el token del usuario por correo electrónico
        $token = $usersModel->getTokenByEmail($email);

        if ($token !== false) {
            // Cambiar la contraseña del usuario con el token proporcionado
            $user = $usersModel->getUserByEmail($email);

            // Hash de la nueva contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Actualizar la contraseña del usuario con el hash
            $usersModel->PasswordUser($user['id'], $hashedPassword);
        } else {
            // El correo electrónico no está registrado o no tiene un token asociado
            // Puedes redirigir a una página de error o mostrar un mensaje de error.
            // Por ejemplo:
            echo "Usuario no encontrado o no tiene un token asociado";
            exit();
        }
    }

    $response->SetTemplate("newpass.php");
    return $response;
}







}