<?php

namespace App\Controllers;

class UserController
{
/**
 * Gestiona la sol·licitud per a la pàgina principal (index).

 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function index($request, $response, $container)
{
    // Obté l'ID de l'usuari actual de la sessió, o estableix 0 si no hi ha sessió.
    $userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0;

    // Obté instàncies del model d'usuaris i del model de fotos d'usuaris.
    $usersModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    // Obté la foto seleccionada de l'usuari actual.
    $photo = $photoModel->getUserSelectedPhoto($userId);

    // Obté tots els usuaris.
    $users = $usersModel->getAllUsers();

    // Configura les dades per a la resposta.
    $response->set("users", $users);
    $response->set("photo", $photo);

    // Estableix la plantilla que s'utilitzarà per a la resposta.
    $response->setTemplate("index.php");

    // Retorna la resposta HTTP que s'enviarà al navegador.
    return $response;
}
    
/**
 * Gestiona la sol·licitud per al perfil d'usuari.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function perfil($request, $response, $container)
{
    // Verifica si l'usuari està autenticat
    if ($_SESSION["logged"]) {
        
        // Crea una instància del model UsersPDO
        $usersModel = $container["\App\Models\usersPDO"];
        $userPhoto = $container["\App\Models\usersPDO"];
        $photoModel = $container["\App\Models\usersPDO"];
        
        // Obté les dades de l'usuari actual
        $userId = $_SESSION["user_id"];
        $user = $usersModel->getUserById($userId);
        $userPhoto = $usersModel->getUserSelectedPhoto($userId);
        $photo = $photoModel->getUserSelectedPhoto($userId);

        // Pasa les dades a la vista
        $response->set("user", $user);
        $response->set("userPhoto", $userPhoto);

        // Truca al mètode del model per obtenir el grup
        $group = $usersModel->getGroupForUser($userId);

        // Pasa les dades a la vista
        $response->set("user", $user);
        $response->set("group", $group);
        $response->set("photo", $photo);

        // Estableix la plantilla
        $response->SetTemplate("perfil.php");
    } else {
        // Si no està autenticat, redirigeix a la pàgina d'inici de sessió o una altra pàgina
        $response->redirect("/login");
    }

    if (isset($_SESSION['error_message'])) {
        echo '<div role="alert" class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded z-50">
                  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                  <span>' . $_SESSION['error_message'] . '</span>
                </div>';
    
        // Clear the error message from the session
        unset($_SESSION['error_message']);
    }

    return $response;
}





   /**
 * Gestiona el procés d'inici de sessió de l'usuari.
 * 
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function login($request, $response, $container)
{
    // Obté les dades d'inici de sessió del formulari
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Crea una instància del model UsersPDO
    $usersModel = $container["\App\Models\usersPDO"];

    // Intenta iniciar sessió amb les credencials proporcionades
    $loggedInUser = $usersModel->login($email, $password);

    if ($loggedInUser) {
        // Configura les variables de sessió amb la informació de l'usuari autenticat
        $_SESSION["user_id"] = $loggedInUser["id"];
        $_SESSION["group_id"] = $loggedInUser["group_id"];
        $_SESSION["logged"] = true;
        $_SESSION["role"] = $loggedInUser["role"];

        // Obté més dades de l'usuari per a mostrar al perfil
        $userId = $_SESSION["user_id"];
        $photoModel = $container["\App\Models\usersPDO"];
        $group = $usersModel->getGroupForUser($userId);
        $user = $usersModel->getUserById($userId);
        $userPhoto = $usersModel->getUserSelectedPhoto($userId);
        $photo = $photoModel->getUserSelectedPhoto($userId);

        // Configura les dades per a la resposta
        $response->set("user", $loggedInUser);
        $response->set("group", $group);
        $response->set("userPhoto", $userPhoto);
        $response->set("photo", $photo);

        // Estableix la plantilla per al perfil
        $response->SetTemplate("perfil.php");
    } else {
        // Si les credencials són incorrectes, mostra un missatge d'error i redirigeix a la pàgina principal
        $response->SetTemplate("index.php");
        $response->set("error_message_login", "Email i/o contrasenya incorrectes");
        $_SESSION["logged"] = false;
    }

    return $response;
}

    


/**
 * Gestiona el procés de tancament de sessió de l'usuari.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function logout($request, $response, $container)
{
    // Invalideu la sessió de l'usuari
    $_SESSION["logged"] = false;

    // Redirigeix a la pàgina principal
    $response->SetTemplate("index.php");
    return $response;
}



   /**
 * Gestiona el procés de registre d'un nou usuari.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function register($request, $response, $container)
{
    // Obtenir una instància del model UsersPDO
    $usersModel = $container["\App\Models\usersPDO"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtindre les dades del formulari
        $name = $_POST["username"];
        $surname = $_POST["surname"];
        $email = $_POST["mail"];
        $phone = $_POST["phone"];
        $dni = $_POST["dni"];
        $birthDate = $_POST["birth_date"];
        $password = $_POST["password"];
        $groupId = $_POST["group"]; // Nou camp per obtenir el grup seleccionat

        // Hashear la contrasenya
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Intentar registrar l'usuari i obtenir l'ID del nou usuari
        $userId = $usersModel->registerUser($name, $surname, $email, $phone, $dni, $birthDate, 'Alumne', $hashedPassword);

        // Associar l'usuari al grup en la taula user_groups
        $usersModel->assignUserToGroup($userId, $groupId);

        // Si no té un token, genera'n un de nou i guarda'l
        if (!$usersModel->getUserToken($userId)) {
            // Generar un token únic
            $token = uniqid();

            // Guardar el token a la base de dades
            $usersModel->saveUserToken($userId, $token);
        }

        // Configurar missatge d'èxit i redirigir a la pàgina principal
        $response->set("success_message_register", "El compte s'ha creat correctament");
        $response->SetTemplate("index.php");

        return $response;
    }

    // Si la sol·licitud no és de tipus POST, redirigir a la pàgina principal
    $response->SetTemplate("index.php");
    return $response;
}


  
/**
 * Gestiona la creació d'un usuari aleatori.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function randomuser($request, $response, $container)
{
    // Obtenir instàncies dels models necessaris
    $usersModel2 = $container["\App\Models\usersPDO"];
    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];

    // Obtenir les dades de l'usuari autenticat
    $userId = $_SESSION["user_id"];
    $photoModel = $container["\App\Models\usersPDO"];
    $photo = $photoModel->getUserSelectedPhoto($userId);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtindre les dades del formulari
        $name = $_POST["username"];
        $surname = $_POST["surname"];
        $email = $_POST["mail"];
        $birthDate = $_POST["birth_date"];
        $role = $_POST["role"];
        $password = $_POST["password"];

        // Hashear la contrasenya
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Configurar missatge d'èxit i redirigir a la pàgina de control
        $response->set("success_message_register", "La compte s'ha creat correctament");
        $response->SetTemplate("paneldecontrol.php");

        // Registrar l'usuari aleatori i obtenir-ne l'ID
        $userId_random = $usersModel2->registerRandomUser($name, $surname, $email, $birthDate, $hashedPassword, $role);

        // Generar un token únic
        $token = uniqid();

        // Guardar el token a la base de dades
        $usersModel2->saveUserToken($userId_random, $token);

        // Obtenir les dades necessàries per a la pàgina de control
        $users = $usersModel->getAllUsers();
        $errors = $errorModel->geterror();
        $orles = $orlaModel->getAllOrles();
        $grups = $grupsModel->getAllGroups();

        // Processar les dades dels usuaris, orles i grups
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

    // Obtenir les dades per a la pàgina de control i configurar la plantilla
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();

    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);
    $response->SetTemplate("paneldecontrol.php");

    return $response;
}



   /**
 * Gestionar la càrrega d'informació d'un usuari.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function uploadUser($request, $response, $container)
{
    // Obtenir instàncies dels models necessaris
    $usersModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtindre les dades del formulari
        $id = $_POST["id"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];

        // Actualitzar les dades de l'usuari
        $usersModel->editUser($id, $name, $surname, $email, $phone);

        // Redirigir a la pàgina de perfil
        header("Location: perfil");
        exit();
    }

    // Obtindre l'ID de l'usuari i les dades corresponents
    $id = $_POST["id"];
    $user = $usersModel->getUserById($id);
    $photo = $photoModel->getUserSelectedPhoto($id);

    // Configurar les dades per a la plantilla i renderitzar la pàgina de perfil
    $response->set("photo", $photo);
    $response->SetTemplate("perfil.php", ["user" => $user]);
    return $response;
}


/**
 * Gestionar la càrrega d'informació d'un usuari per a l'administrador.
 *
 * @param \Emeset\Http\Request $request Objecte que representa la sol·licitud HTTP.
 * @param \Emeset\Http\Response $response Objecte que representa la resposta HTTP.
 * @param mixed $container Contenidor de dependències que proporciona accés a serveis i recursos.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function uploadUserAdmin($request, $response, $container)
{
    // Obtindre l'ID de l'usuari autenticat
    $userId = $_SESSION["user_id"];

    // Obtindre instàncies dels models necessaris
    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtindre les dades del formulari
        $id = $_POST["id"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $dni = $_POST["dni"];
        $birth_date = $_POST["birth_date"];
        $group_name = $_POST["group"];
        $role = $_POST["role"];

        // Actualitzar les dades de l'usuari
        $usersModel->editUserAdmin($id, $name, $surname, $email, $phone, $dni, $birth_date, $group_name, $role);
    }

    // Obtindre les dades necessàries per a la pàgina de panell de control
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
    $photo = $photoModel->getUserSelectedPhoto($userId);

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

    // Configurar les dades per a la plantilla i renderitzar la pàgina de panell de control
    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);

    $response->SetTemplate("paneldecontrol.php");
    return $response;
}

/**
 * Generar la visualització del carnet d'un usuari, basat en la sessió actual.
 * 
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function carnetUser($request, $response, $container)
{
    // Obtenir l'ID de l'usuari des de la sessió
    $userId = $_SESSION["user_id"];

    // Obtenir instàncies dels models necessaris
    $usersModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    // Obtenir la foto seleccionada de l'usuari des de la base de dades
    $photo = $photoModel->getUserSelectedPhoto($userId);
    $response->set("photo", $photo);

    // Buscar l'usuari per l'ID proporcionat pel token
    $user = $usersModel->getUserByToken($request->getParam("token"));

    if ($user || $userId) {
        // Si l'usuari existeix o hi ha una sessió iniciada, obtenir la informació
        if (!$user) {
            // Si no hi ha usuari però hi ha una sessió iniciada, obtenir la informació de l'usuari loggejat
            $user = $usersModel->getUserById($userId);
        }

        // Obtenir el grup de l'usuari
        $group = $usersModel->getGroupForUser($user["id"]);

        // Passar les dades a la vista
        $response->set("user", $user);
        $response->set("group", $group);
        $response->set("uniqueUrl", "/carnet/{$user["id"]}");

        // Establir la plantilla
        $response->setTemplate("carnet.php");
    } else {
        // Si el token no coincideix amb cap usuari i no hi ha cap sessió, mostrar un missatge d'error
        $response->set("error", "Usuari no trobat");
        $response->setTemplate("error.php"); // Assegura't de tenir una plantilla per mostrar errors
    }

    return $response;
}

    
/**
 * Genera la visualització del carnet d'un usuari basat en un token proporcionat a través de la URL.
 *
 * @param \Emeset\Http\Request $request Objecte que representa la sol·licitud HTTP.
 * @param \Emeset\Http\Response $response Objecte que representa la resposta HTTP.
 * @param mixed $container Contenidor de dependències que proporciona accés a serveis i recursos.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function carnetUserUrl($request, $response, $container)
{
    // Obtenir l'ID de l'usuari des de la sessió
    $userId = $_SESSION["user_id"];

    // Obtenir instàncies dels models necessaris
    $usersModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    // Obtenir la foto seleccionada de l'usuari des de la base de dades
    $photo = $photoModel->getUserSelectedPhoto($userId);
    $response->set("photo", $photo);

    // Buscar l'usuari pel token proporcionat a través de la URL
    $user = $usersModel->getUserByToken($request->getParam("token"));

    // Verificar si l'usuari es troba pel token
    if ($user) {
        // Si l'usuari es troba pel token, obtenir la informació
        $group = $usersModel->getGroupForUser($user["id"]);

        // Passar les dades a la vista
        $response->set("user", $user);
        $response->set("group", $group);
        $response->set("uniqueUrl", "/carnet/{$user["id"]}");

        // Establir la plantilla
        $response->setTemplate("carnet.php");
    } else {
        // Si el token no coincideix amb cap usuari, mostrar un missatge d'error
        $response->set("error", "Usuari no trobat");
        $response->setTemplate("errortoken.php");
    }

    return $response;
}

    
    
    

/**
 * Mostra les fotos associades a un usuari específic.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function photoUser($request, $response, $container)
{
    // Obtenir l'ID de l'usuari des de la sessió
    $userId = $_SESSION["user_id"];

    // Obtenir una instància del model necessari
    $usersModel = $container["\App\Models\usersPDO"];

    // Obtenir les fotos de l'usuari des de la base de dades
    $photos = $usersModel->getUserPhotos($userId);

    // Passar les dades a la vista
    $response->set("photos", $photos);

    // Establir la plantilla
    $response->setTemplate("photo.php");

    return $response;
}



/**
 * Pujar una foto de perfil per a l'usuari actual.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function uploadPhoto($request, $response, $container)
{
    // Obtenir l'ID de l'usuari des de la sessió
    $userId = $_SESSION["user_id"];

    // Obtenir una instància del model necessari
    $uploadUserPhotoModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    // Obtenir la foto seleccionada de l'usuari
    $photo = $photoModel->getUserSelectedPhoto($userId);

    // Verificar si s'ha enviat la foto seleccionada
    if (isset($_POST["selectedPhoto"])) {
        $selectedPhoto = $_POST["selectedPhoto"];

        // Desactivar totes les fotos de l'usuari
        $uploadUserPhotoModel->deactivateUserPhotos($userId);

        // Activar la foto seleccionada
        $uploadUserPhotoModel->activateSelectedPhoto($userId, $selectedPhoto);

        // Redirigir a la pàgina de perfil
        header("Location: perfil");
        exit();
    } else {
        $_SESSION['error_message'] = 'Has de seleccionar una fotografia!';

    // Redirect to the perfil page
    header("Location: perfil");
    exit();
    }

    // Passar la foto a la vista
    $response->set("photo", $photo);

    return $response;
}

    

    /**
 * Funció per gestionar la pàgina de cerca d'alumnes.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function cercador($request, $response, $container)
{
    // Obtenir l'ID de l'usuari des de la sessió
    $userId = $_SESSION["user_id"];

    // Obtenir una instància del model d'usuaris necessari
    $alumnesModel = $container["\App\Models\usersPDO"];

    // Obté els alumnes assignats a un professor específic
    $alumnes = $alumnesModel->getAlumnesByProfessor($userId);

    // Passar els alumnes a la vista
    $response->set("alumnes", $alumnes);

    // Establir la plantilla
    $response->SetTemplate("cercador.php");

    return $response;
}


    /**
 * Funció per gestionar la pàgina d'alumnes d'un professor.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function alumnes($request, $response, $container)
{
    // Obtenir l'ID de l'usuari des de la sessió
    $userId = $_SESSION["user_id"];

    // Obtenir una instància del model d'usuaris i del model de fotos necessaris
    $alumnesModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    // Obté els alumnes assignats a un professor específic
    $alumnes = $alumnesModel->getAlumnesByProfessor($userId);

    // Obté la foto seleccionada de l'usuari actual
    $photo = $photoModel->getUserSelectedPhoto($userId);

    // Passar els alumnes i la foto a la vista
    $response->set("alumnes", $alumnes);
    $response->set("photo", $photo);

    // Establir la plantilla
    $response->SetTemplate("alumnes.php");

    return $response;
}

    
   /**
 * Funció per gestionar la pàgina de contactar.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function contactar($request, $response, $container)
{
    // Obtenir l'ID de l'usuari des de la sessió
    $userId = $_SESSION["user_id"];

    // Obtenir una instància del model de fotos necessari
    $photoModel = $container["\App\Models\usersPDO"];

    // Obté la foto seleccionada de l'usuari actual
    $photo = $photoModel->getUserSelectedPhoto($userId);

    // Passar la foto a la vista associada "contactar.php"
    $response->set("photo", $photo);

    // Establir la plantilla
    $response->SetTemplate("contactar.php");

    return $response;
}


/**
 * Funció per gestionar l'enviament de missatges de contactar.
 *
 * @return \Emeset\Http\Response La resposta HTTP que s'enviarà al navegador.
 */
public function enviarcontactar($request, $response, $container)
{
    // Obtenir l'ID de l'usuari des de la sessió
    $userId = $_SESSION["user_id"];

    // Comprovar si la sol·licitud és una petició POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtenir les dades del formulari
        $mensaje = $_POST["mensaje"];
        $email = $_POST["email"];

        // Obté les instàncies del model necessàries
        $errorModel = $container["\App\Models\usersPDO"];
        $photoModel = $container["\App\Models\usersPDO"];

        // Obté la foto seleccionada de l'usuari actual
        $photo = $photoModel->getUserSelectedPhoto($userId);

        // Crea un error amb el missatge proporcionat i l'ID de l'usuari
        $Createerror = $errorModel->createerror($userId, $mensaje);

        // Passa la foto a la vista associada "contactar.php"
        $response->set("photo", $photo);

        // Establir la plantilla
        $response->SetTemplate("contactar.php");

        return $response;
    } else {
        // Si no és una petició POST, mostra un missatge d'error
        echo 'error';
    }
}

/**
 * Funció per obtenir informació específica del panell de control per a un usuari.
 *
 * @return \Emeset\Http\Response Resposta HTTP.
 */
public function Idpanel($request, $response, $container)
{
    // Obté la ID de l'usuari des de la sessió
    $userId = $_SESSION["user_id"];
    
    // Accedeix al model d'usuaris des del contenidor
    $usersModel = $container["\App\Models\usersPDO"];

    // Obté informació específica del panell de control per a l'usuari
    $users = $usersModel->Idpanel($userId);

    // Estableix les dades de l'usuari i les passa a la vista del panell de control
    $response->set("users", $users);

    // Estableix la plantilla a utilitzar
    $response->SetTemplate("paneldecontrol.php");

    // Retorna la resposta HTTP
    return $response;
}
   

   /**
 * Gestiona la eliminació d'un usuari.
 *
 * @return \Emeset\Http\Response La resposta HTTP amb les dades actualitzades.
 */
public function deleteUser($request, $response, $container)
{
    // Obté l'ID de l'usuari a eliminar des del paràmetre de la sol·licitud GET
    $user_id = $_GET['id'];
    
    // Obté l'ID de l'usuari actual autenticat des de la sessió
    $userId = $_SESSION["user_id"];

    // Crea instàncies dels models necessaris
    $OrlaModel = $container["\App\Models\Orles"];
    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    // Obté les dades necessàries per mostrar la pàgina de panell de control
    $grupsModel = $container["\App\Models\usersPDO"];
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $OrlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
    
    // Itera sobre els usuaris per obtenir les fotos i grups associats
    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    // Itera sobre els grups per obtenir els usuaris associats
    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    // Elimina l'usuari de la base de dades
    $usersModel->deleteUser($user_id);

    // Configura les dades per actualitzar la pàgina de panell de control
    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);

    // Estableix la plantilla per la pàgina de panell de control
    $response->SetTemplate("paneldecontrol.php");

    return $response;
}


/**
 * Gestiona l'eliminació d'un error.
 *
 * @return \Emeset\Http\Response La resposta HTTP amb les dades actualitzades.
 */
public function deleteerror($request, $response, $container)
{
    // Obté l'ID de l'error a eliminar des del paràmetre de la sol·licitud GET
    $error_id = $_GET['id'];
    
    // Crea instàncies dels models necessaris
    $errorrModel = $container["\App\Models\usersPDO"];
    $errorrModel->deleteerror($error_id);
    
    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];
    
    // Obté les dades necessàries per mostrar la pàgina de panell de control
    $userId = $_SESSION["user_id"];
    $photoModel = $container["\App\Models\usersPDO"];
    $photo = $photoModel->getUserSelectedPhoto($userId);
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();

    // Itera sobre els usuaris per obtenir les fotos i grups associats
    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    // Itera sobre els orles per obtenir les fotos associades
    foreach ($orles as &$orla) {
        $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
    }

    // Itera sobre els grups per obtenir els usuaris associats
    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    // Configura les dades per actualitzar la pàgina de panell de control
    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);
    
    // Estableix la plantilla per la pàgina de panell de control
    $response->SetTemplate("paneldecontrol.php");

    return $response;
}


  /**
 * Gestiona la càrrega d'un error.
 *
 * @return \Emeset\Http\Response La resposta HTTP amb les dades actualitzades.
 */
public function uploaderror($request, $response, $container)
{
    // Verifica si es reben les dades correctament
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST["error_status"];
        $error_id = $_POST["id"];  // Canviat a $_POST["id"]

        $errorModel = $container["\App\Models\usersPDO"];

        // Verifica si la funció uploadError està implementada correctament a UsersPDO
        $errorModel->uploadError($error_id, $status);
    } else {
        echo 'error';
    }

    // Crea instàncies dels models necessaris
    $usersModel = $container["\App\Models\usersPDO"];
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    // Obté les dades necessàries per mostrar la pàgina de panell de control
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
    $photo = $photoModel->getUserSelectedPhoto($id);
    
    // Itera sobre els usuaris per obtenir les fotos i grups associats
    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    // Itera sobre els orles per obtenir les fotos associades
    foreach ($orles as &$orla) {
        $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
    }

    // Itera sobre els grups per obtenir els usuaris associats
    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    // Configura les dades per actualitzar la pàgina de panell de control
    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);

    // Estableix la plantilla per la pàgina de panell de control
    $response->SetTemplate("paneldecontrol.php");

    return $response;
}

 
/**
 * Pujar una foto de l'alumne des d'un fitxer.
 *
 * @return \Emeset\Http\Response La resposta HTTP amb les dades actualitzades.
 */
public function uploadPhotoFromFile($request, $response, $container)
{
    // Verifica si es reben les dades correctament
    if (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];

        // Verifica si no hi ha errors en la pujada del fitxer
        if ($file['error'] === UPLOAD_ERR_OK) {
            $tmpFilePath = $file['tmp_name'];

            // Genera un nom únic pel fitxer
            $newFileName = uniqid('image_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

            // Defineix la ruta de destí per desar el fitxer
            $destinationPath = "img/" . $newFileName;

            // Mou el fitxer carregat a la ruta de destí
            if (move_uploaded_file($tmpFilePath, $destinationPath)) {
                // Mostra un missatge d'èxit
                $successMessage = '
                <div role="alert" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded z-50">
                      <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                      <span>Has pujat i actualitzat la foto del alumne</span>
                    </div>
                ';

                echo $successMessage;

                // Crea instàncies dels models necessaris
                $usersModel = $container["\App\Models\usersPDO"];
                $UploadUserPhoto = $container["\App\Models\usersPDO"];

                // Obté l'ID de l'alumne
                $user_id = $_POST['user_id']; 
                $userId = $_SESSION["user_id"];

                // Desactiva totes les fotos de l'alumne
                $UploadUserPhoto->deactivateUserPhotos($user_id);

                // Pujar la nova foto de l'alumne
                $usersModel->uploadPhotoFromFile($user_id, $destinationPath, 'active');
            } else {
                echo "Error al guardar la imatge.";
            }
        } else {
           echo '<div role="alert" class="fixed bottom-4 right-4 bg-amber-500 text-white px-4 py-2 rounded z-50 w-xs">
           <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
           <span>Atenció: Has de seleccionar una foto!</span>
         </div>';
        }
    } else {
        echo "No s'ha enviat cap imatge.";
    }

    // Obté les dades necessàries per mostrar la pàgina d'alumnes
    $userId = $_SESSION["user_id"];
    $photoModel = $container["\App\Models\usersPDO"];
    $alumnes = $container["\App\Models\usersPDO"];
    $alumnes = $alumnes->getAlumnesByProfessor($userId);
    $photo = $photoModel->getUserSelectedPhoto($userId);

    // Configura les dades per actualitzar la pàgina d'alumnes
    $response->set("alumnes", $alumnes);
    $response->set("photo", $photo);
    $response->SetTemplate("alumnes.php");

    return $response;
}

/**
 * Funció que gestiona la pujada de fotos d'estudiants des d'un fitxer.
 *
 * @return \Emeset\Http\Response La resposta HTTP amb la plantilla actualitzada.
 */
public function uploadPhotoFromFileEdit($request, $response, $container)
{
    // Assegura't que s'ha enviat la informació de la imatge en Base64
    if (isset($_POST['photo'])) {
        // Obté la imatge en format Base64
        $base64Image = $_POST['photo'];

        // Decodifica la imatge Base64
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

        // Genera un nom de fitxer únic
        $newFileName = uniqid('image_') . '.png';

        // Ruta de destí per desar la imatge
        $destinationPath = "img/" . $newFileName;

        // Desa la imatge al servidor
        if (file_put_contents($destinationPath, $imageData)) {
            // Èxit en desar la imatge
            $successMessage = '<div role="alert" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Has pujat i actualitzat la foto de estudiant</span>
            </div>';

            echo $successMessage;

            // Resta del codi per interactuar amb la base de dades
            $usersModel = $container["\App\Models\usersPDO"];
            $UploadUserPhoto = $container["\App\Models\usersPDO"];

            $user_id = $_POST['user_id']; 
            $userId = $_SESSION["user_id"];
            
            // Desactiva totes les altres fotos de l'estudiant
            $UploadUserPhoto->deactivateUserPhotos($user_id);
            
            // Pujar la nova foto i activar-la
            $usersModel->uploadPhotoFromFile($user_id, $destinationPath, 'active');

        } else {
            echo "Error al desar la imatge.";
        }
    } else {
        echo "No s'ha enviat cap imatge.";
        var_dump($_POST);
    }

    // Resta del codi per carregar dades i renderitzar la plantilla
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


/**
 * Funció que gestiona la eliminació d'un grup específic.
 *
 * @return \Emeset\Http\Response La resposta HTTP amb les dades actualitzades.
 */
public function DeleteGrup($request, $response, $container)
{
    // Obtenir l'identificador de grup des dels paràmetres de la sol·licitud
    $grup_id = $_GET['id'];

    // Accedir al model d'usuaris des del contenidor
    $usersModel = $container["\App\Models\usersPDO"];

    // Eliminar el grup utilitzant el model d'usuaris
    $usersModel->DeleteGrup($grup_id);

    // Obtenir l'identificador d'usuari de la sessió actual
    $userId = $_SESSION["user_id"];

    // Accedir als models necessaris des del contenidor
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];
    $photoModel = $container["\App\Models\usersPDO"];

    // Obtindre la foto seleccionada de l'usuari actual
    $photo = $photoModel->getUserSelectedPhoto($userId);
   
    // Obtindre tots els usuaris, errors, orles i grups per actualitzar la resposta
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();

    // Afegir informació addicional als usuaris
    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    // Afegir informació addicional a les orles
    foreach ($orles as &$orla) {
        $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
    }

    // Afegir informació addicional als grups
    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    // Actualitzar la resposta amb les dades actualitzades
    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);
    $response->set("photo", $photo);
    
    // Establir la plantilla de resposta al panell de control
    $response->SetTemplate("paneldecontrol.php");
    return $response;
}


/**
 * Funció que gestiona la creació d'un grup nou.
 *
 * @return \Emeset\Http\Response La resposta HTTP amb les dades actualitzades.
 */
public function crearGrup($request, $response, $container)
{  
    // Obtenció del nom del grup a partir de les dades del formulari
    $name = $_POST["name"];

    // Injecció del model d'usuaris des del contenidor
    $usersModel = $container["\App\Models\usersPDO"];
    
    // Creació del grup amb el nom proporcionat
    $usersModel->crearGrup($name);
    
    // Obtenció de l'identificador de l'usuari actual des de la sessió
    $userId = $_SESSION["user_id"];
    
    // Obtenció de la informació del panell per a l'usuari actual
    $users = $usersModel->Idpanel($userId);

    // Injecció dels models relacionats
    $errorModel = $container["\App\Models\usersPDO"];
    $orlaModel = $container["\App\Models\Orles"];
    $grupsModel = $container["\App\Models\usersPDO"];
    
    // Obtenció de diverses dades necessàries
    $users = $usersModel->getAllUsers();
    $errors = $errorModel->geterror();
    $orles = $orlaModel->getAllOrles();
    $grups = $grupsModel->getAllGroups();
    
    // Iteració sobre els usuaris per afegir informació addicional
    foreach ($users as &$user) {
        $user["photos"] = $usersModel->getUserPhotos($user["id"]);
        $groups = $usersModel->getGroupByUserId($user["id"]);
    
        if ($groups !== null) {
            $user["groups"] = $groups;
        } else {
            $user["groups"] = 'Sense grup';
        }
    }

    // Iteració sobre les orles per afegir informació addicional
    foreach ($orles as &$orla) {
        $orla["photos"] = $orlaModel->getAllPhotosOrla($orla["orla_id"]);
    }

    // Iteració sobre els grups per afegir informació addicional
    foreach ($grups as &$grup) {
        $grup["users"] = $grupsModel->getAllUsersGrup($grup["id"]);
    }

    // Configuració de les dades a la resposta HTTP
    $response->set("users", $users);
    $response->set("errors", $errors);
    $response->set("orles", $orles);
    $response->set("grups", $grups);

    // Configuració addicional de les dades a la resposta HTTP
    $response->set("users", $users);

    // Configuració de la plantilla a utilitzar per la resposta
    $response->SetTemplate("paneldecontrol.php");
    
    // Retorn de la resposta HTTP
    return $response;
}

/**
 * Funció que gestiona l'enviament d'un correu electrònic de recuperació de contrasenya.
 *
 * @return \Emeset\Http\Response La resposta HTTP amb la plantilla actualitzada.
 */
public function sendRecoveryEmail($request, $response, $container) {
    // Injecció del model d'usuaris des del contenidor
    $emailModel = $container["\App\Models\usersPDO"];

    // Obtenció del correu electrònic del formulari
    $email = $_POST["email"];

    // Verificació de l'existència del correu electrònic a la lògica de l'aplicació
    if ($emailModel->emailExists($email)) {
        // Generació d'un token únic
        $token = uniqid();

        // Emmagatzematge del token a la base de dades
        $emailModel->storeToken($email, $token);

        // Intent de l'enviament del correu electrònic de recuperació amb el token
        try {
            $emailModel->RecoveryEmail($email, $token);

            // Correu electrònic enviat amb èxit per a la recuperació de contrasenya
            $response->SetTemplate("sendemail.php");
            return $response;

        } catch (\Exception $e) {
            // Maneig segur de l'error (pot ser registrat en un fitxer de registre)
            $response->SetTemplate("erroremail.php");
            return $response;
        }
    }

    // Si el correu electrònic no existeix, redirecció a la pàgina d'error
    $response->SetTemplate("erroremail.php");
    return $response;
}

/**
 * Funció que gestiona el canvi de contrasenya per mitjà d'un formulari.
 *
 * @return \Emeset\Http\Response La resposta HTTP amb la plantilla actualitzada.
 */
public function newpass($request, $response, $container)
{
    // Injecció del model d'usuaris des del contenidor
    $usersModel = $container["\App\Models\usersPDO"];

    // Comprova si la sol·licitud és de tipus POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obté el correu electrònic i la nova contrasenya del formulari
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Obté el token associat al correu electrònic de l'usuari
        $token = $usersModel->getTokenByEmail($email);

        // Verifica si s'ha trobat un token vàlid
        if ($token !== false) {
            // Obté les dades de l'usuari amb el correu electrònic
            $user = $usersModel->getUserByEmail($email);

            // Genera el hash de la nova contrasenya
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Actualitza la contrasenya de l'usuari amb el nou hash
            $usersModel->PasswordUser($user['id'], $hashedPassword);

            // Redirigeix a la vista "uploadpass.php" després de canviar la contrasenya
            $response->SetTemplate("uploadpass.php");
            return $response;
        } else {
            // El correu electrònic no està registrat o no té un token associat
            // Pots redirigir a una pàgina d'error o mostrar un missatge d'error.
            // Per exemple:
            $response->SetTemplate("erroremail.php");
            return $response;
        }
    }

    // Configuració de la plantilla a utilitzar per la resposta si no és una sol·licitud POST
    $response->SetTemplate("newpass.php");
    return $response;
}

}