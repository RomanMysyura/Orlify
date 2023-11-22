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

            // Obtén los datos del usuario actual
            $userId = $_SESSION["user_id"];
            $user = $usersModel->getUserById($userId);

            // Pasa los datos a la vista
            $response->set("user", $user);

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
            $_SESSION["logged"] = true;
            $userId = $_SESSION["user_id"];
            $user = $usersModel->getUserById($userId);

            
            $response->set("user", $user);
            
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
            $birthDate = $_POST["birth_date"];
            $password = $_POST["password"];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $response->set("error_message_register", "La conta creada correctament");
            $response->SetTemplate("index.php");
            $usersModel->registerUser($name, $surname, $email, $birthDate, $hashedPassword);

            
            return $response;
        }

        $response->SetTemplate("index.php");
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
    
            $usersModel->editUser($id, $name, $surname, $email);
    
            header("Location: perfil");
            exit();
        }
    
        $id = $_POST["id"];
        $user = $usersModel->getUserById($id);
    
        $response->SetTemplate("perfil.php", ["user" => $user]);
        return $response;
    }
    
    
    
}