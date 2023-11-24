<?php

namespace App\Controllers;

use App\Models\Db;
use App\Models\UsersPDO;

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
            $user = $usersModel->getUserById($userId);
            $group = $usersModel->getGroupForUser($userId);
    
            $response->set("user", $user);
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
            $userId = $usersModel->registerUser($name, $surname, $email,$phone,$dni, $birthDate, $hashedPassword);
    
            // Asociar el usuario al grupo en la tabla user_groups
            $usersModel->assignUserToGroup($userId, $groupId);
    
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
    
            $usersModel->editUser($id, $name, $surname, $email,$phone);
    
            header("Location: perfil");
            exit();
        }
    
        $id = $_POST["id"];
        $user = $usersModel->getUserById($id);
    
        $response->SetTemplate("perfil.php", ["user" => $user]);
        return $response;
    }
    public function carnetUser($request, $response, $container)
    {
        // Verifica si el usuario está autenticado
        if ($_SESSION["logged"]) {
            // Obtén la conexión a la base de datos
            $dbConfig = $container["config"]["database"];
            $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
            $connection = $dbModel->getConnection();

            // Crea una instancia del modelo UsersPDO
            $usersModel = new UsersPDO($connection);

            // Obtén los datos del usuario actual
            $userId = $_SESSION["user_id"];
            $user = $usersModel->getUserById($userId);
        
            // Llama al método del modelo para obtener el grupo
            $group = $usersModel->getGroupForUser($userId);
           
           
            
        
            // Pasa los datos a la vista
            $response->set("user", $user);
            $response->set("group", $group);

            // Establece la plantilla
            $response->SetTemplate("carnet.php");
        } else {
            // Si no está autenticado, redirige a la página de inicio de sesión u otra página
            $response->redirect("/login");
        }

        return $response;
    }
 

    
    public function photoUser($request, $response, $container) {

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


    public function uploadPhoto($request, $response, $container) {
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();
    
        $userId = $_SESSION["user_id"];
    
        $UploadPhotoNo = new UsersPDO($connection);
        $UploadPhotosi = new UsersPDO($connection);
    
        if (isset($_POST["selectedPhoto"])) {
            $selectedPhoto = $_POST["selectedPhoto"];
    
            $UploadPhotoNo->selectPhotoNo($userId);
            $UploadPhotosi->selectPhotoSi($userId, $selectedPhoto);
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
    
            $usersModel->PaneleditUser($id, $name, $surname, $email,$phone,$dni,$birth_date,$role);
    
            header("Location: paneldecontrol");
            exit();
        }
    
        $id = $_POST["id"];
        $user = $usersModel->getUserById($id);
    
        $response->SetTemplate("paneldecontrol.php", ["user" => $user]);
        return $response;
    }
    public function Idpanel($request, $response, $container) {

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
        $user_id = $_GET['id']; // Obtener el ID de la orla desde la URL
    
        $dbConfig = $container["config"]["database"];
        $dbModel = new Db($dbConfig["username"], $dbConfig["password"], $dbConfig["database"], $dbConfig["server"]);
        $connection = $dbModel->getConnection();
    
        $usersModel = new UsersPDO($connection);
        $usersModel->deleteUser($user_id);
        $userId = $_SESSION["user_id"];
        $users = $usersModel-IdPanel($userId);
    
        $response->set("users", $users);
    
        $response->SetTemplate("paneldecontrol.php");
        return $response;
    }
    }