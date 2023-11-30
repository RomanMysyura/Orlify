<?php

namespace App\Controllers;

use App\Models\Db;
use App\Models\UsersPDO;
use App\Models\Orles;

class UserController
{

    public function index($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);

        $users = $usersModel->getAllUsers();

        $response->set("users", $users);

        $response->SetTemplate("index.php");

        return $response;
    }





    public function perfil($request, $response, $container)
    {
        // Verifica si el usuario está autenticado
        if ($_SESSION["logged"]) {
            // Obtén la conexión a la base de datos
            $dbConfig = $container["config"]["database"];
            $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
            $connection = $dbModel->getConnection();

            // Crea una instancia del modelo UsersPDO
            $usersModel = new UsersPDO($connection);
            $userPhoto = new UsersPDO($connection);

            // Obtén los datos del usuario actual
            $userId = $_SESSION["user_id"];
            $user = $usersModel->getUserById($userId);
            $userPhoto = $usersModel->getUserSelectedPhoto($userId);

            // Pasa los datos a la vista
            $response->set("user", $user);
            $response->set("userPhoto", $userPhoto);

            // Llama al método del modelo para obtener el grupo
            $group = $usersModel->getGroupForUser($userId);




            // Pasa los datos a la vista
            $response->set("user", $user);
            $response->set("group", $group);

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

        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);

        $loggedInUser = $usersModel->login($email, $password);

        if ($loggedInUser) {
            $_SESSION["user_id"] = $loggedInUser["id"];
            $_SESSION["group_id"] = $loggedInUser["group_id"];
            $_SESSION["logged"] = true;
            $userId = $_SESSION["user_id"];
            $group = $usersModel->getGroupForUser($userId);

            $response->set("user", $loggedInUser);
            $response->set("group", $group);

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
        // Obtén la conexión a la base de datos
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);

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
            $userId = $usersModel->registerUser($name, $surname, $email, $phone, $dni, $birthDate, $hashedPassword);

            // Asociar el usuario al grupo en la tabla user_groups
            $usersModel->assignUserToGroup($userId, $groupId);
              // Verifica si el usuario ya tiene un token
              $existingToken = $usersModel->getUserToken($userId);
    
              // Si no tiene un token, genera uno nuevo y guárdalo
              if (empty($existingToken)) {
                  // Genera un token único
                  $token = uniqid();
      
                  // Guarda el token en la base de datos
                  $usersModel->saveUserToken($userId, $token);
              } else {
                  // Si ya tiene un token, utiliza el existente
                  $token = $existingToken;
              }
      
              // Construye la URL completa con el token como parámetro de ruta
              $uniqueUrl = "https://tuwebapp.com/carnet/{$token}";

            return $response;
        }

        $response->SetTemplate("index.php");
        return $response;
    }

    public function randomuser($request, $response, $container)
    {
        // Obtén la conexión a la base de datos
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["username"];
            $surname = $_POST["surname"];
            $email = $_POST["mail"];
            $birthDate = $_POST["birth_date"];
            $password = $_POST["password"];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $response->set("error_message_register", "La conta creada correctament");
            $response->SetTemplate("paneldecontrol.php");
            $usersModel->registerUser($name, $surname, $email, $birthDate, $hashedPassword);


            return $response;
        }

        $response->SetTemplate("paneldecontrol.php");
        return $response;
    }

    public function updateUser($request, $response, $container)
    {


        $response->SetTemplate("index.php");
        return $response;
    }

    public function uploadUser($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);

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

        $response->SetTemplate("perfil.php", ["user" => $user]);
        return $response;
    }

    public function uploadUserAdmin($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $dni = $_POST["dni"];
            $birth_date = $_POST["birth_date"];
            $role = $_POST["role"];
            

            $usersModel->editUserAdmin($id, $name, $surname, $email, $phone, $dni, $birth_date, $role);

       
        }

        $id = $_POST["id"];
        $user = $usersModel->getUserById($id);

        $response->SetTemplate("paneldecontrol.php", ["user" => $user]);
        return $response;

    }
    public function carnetUser($request, $response, $container)
    {
        $id = $request->getParam("token");
    
        // Verifica si el token está presente en la base de datos
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();
    
        $usersModel = new UsersPDO($connection);
    
        // Busca el usuario por el token
        $user = $usersModel->getUserByToken($id);
    
        if ($user || $userId = $_SESSION["user_id"]) {
            // Si el usuario existe o hay un token en la sesión, obtén la información
            if (!$user) {
                // Si no hay usuario pero hay un token en la sesión, obtén la información del usuario loggeado
                $user = $usersModel->getUserById($userId);
            }
        
            $group = $usersModel->getGroupForUser($user["id"]);
            // Pasa los datos a la vista
            $response->set("user", $user);
            $response->set("group", $group);
            $response->set("uniqueUrl", "http://localhost:8080/carnet/{$user["id"]}");
        
            // Establece la plantilla
            $response->setTemplate("carnet.php");
        } else {
            // Si el token no coincide con ningún usuario y no hay token en la sesión, muestra un mensaje de error
            $response->set("error", "Usuario no encontrado");
            $response->setTemplate("error.php"); // Asegúrate de tener una plantilla para mostrar errores
        }
        
    
        return $response;
    }
    
    
    




    public function photoUser($request, $response, $container)
    {

        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $userId = $_SESSION["user_id"];

        $usersModel = new UsersPDO($connection);

        $photos = $usersModel->getUserPhotos($userId);

        $response->set("photos", $photos);
        $response->SetTemplate("photo.php");
        return $response;

    }


    public function uploadPhoto($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();
    
        $userId = $_SESSION["user_id"];
    
        $UploadUserPhoto = new UsersPDO($connection);
    
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
    
        return $response;
    }
    

    public function cercador($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $userId = $_SESSION["user_id"];


        $alumnes = new UsersPDO($connection);

        $alumnes = $alumnes->getAlumnesByProfessor($userId);


        $response->set("alumnes", $alumnes);
        $response->SetTemplate("cercador.php");

        return $response;
    }

    public function alumnes($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $userId = $_SESSION["user_id"];

        $alumnes = new UsersPDO($connection);

        $alumnes = $alumnes->getAlumnesByProfessor($userId);

        $response->set("alumnes", $alumnes);
        $response->SetTemplate("alumnes.php");

        return $response;
    }
    
    public function contactar($request, $response, $container)
    {

      
        
        
         $response->SetTemplate("contactar.php");
        return $response;
 
    }

    public function enviarcontactar($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $userId = $_SESSION["user_id"];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $mensaje = $_POST["mensaje"];
        $email = $_POST["email"];

        $errorModel = new UsersPDO($connection);
        $Createerror = $errorModel->createerror($userId, $mensaje);

        $response->SetTemplate("contactar.php");
        return $response;
        } else {
            echo 'error';
        }
 
    }

   

    public function PanelUploadUser($request, $response, $container)
    {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $dni = $_POST["dni"];
            $birth_date = $_POST["birth_date"];
            $role = $_POST["role"];

            $usersModel->PaneleditUser($id, $name, $surname, $email, $phone, $dni, $birth_date, $role);

            header("Location: paneldecontrol");
            exit();
        }

        $id = $_POST["id"];
        $user = $usersModel->getUserById($id);

        $response->SetTemplate("paneldecontrol.php", ["user" => $user]);
        return $response;
    }

    
    public function Idpanel($request, $response, $container)
    {

        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $userId = $_SESSION["user_id"];

        $usersModel = new UsersPDO($connection);

        $users = $usersModel->Idpanel($userId);

        $response->set("users", $users);
        $response->SetTemplate("paneldecontrol.php");
        return $response;

    }
    public function deleteUser($request, $response, $container)
    {
        $user_id = $_GET['id'];

        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();

        $usersModel = new UsersPDO($connection);
        $usersModel->deleteUser($user_id);
        $userId = $_SESSION["user_id"];
        $users = $usersModel->Idpanel($userId);

        $response->set("users", $users);

        $response->SetTemplate("paneldecontrol.php");
        return $response;
    }

  public function deleteerror($request, $response, $container){

    $error_id = $_GET['id'];

    $dbConfig = $container["config"]["database"];
    $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
    $connection = $dbModel->getConnection();



    $errorModel = new UsersPDO($connection);
    $errorModel->deleteerror($error_id);

    $response->SetTemplate("paneldecontrol.php");
  return $response;

  }

  public function uploaderror($request, $response, $container) {
    $dbConfig = $container["config"]["database"];
    $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
    $connection = $dbModel->getConnection();

    // Verifica si se están enviando los datos correctamente
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST["error_status"];
        $error_id = $_POST["id"];  // Cambiado a $_POST["id"]

        $errorModel = new UsersPDO($connection);

        // Verifica si la función uploadError está implementada correctamente en UsersPDO
        $errorModel->uploadError($error_id, $status);

       
      
    } else {
        echo 'error';

    }

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
                <div role="alert" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded">
                      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                      <span>Haz pujat i actualitzat la foto del alumne</span>
                    </div>
            ';

            // Imprimir el mensaje de éxito
            echo $successMessage;

                $dbConfig = $container["config"]["database"];
                $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
                $connection = $dbModel->getConnection();

                $usersModel = new UsersPDO($connection);
                $UploadUserPhoto = new UsersPDO($connection);

                $user_id = $_POST['user_id']; 
                $userId = $_SESSION["user_id"];
                $UploadUserPhoto->deactivateUserPhotos($user_id);
                $usersModel->uploadPhotoFromFile($user_id, $destinationPath, 'active');
               
    
            } else {
                echo "Error al guardar la imagen.";
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se ha enviado ninguna imagen.";
    }
    $userId = $_SESSION["user_id"];

    $alumnes = new UsersPDO($connection);

    $alumnes = $alumnes->getAlumnesByProfessor($userId);

    $response->set("alumnes", $alumnes);
    $response->SetTemplate("alumnes.php");
    return $response;
}



}