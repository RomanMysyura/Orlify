<?php

namespace App\Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class usersPDO
{
    private $sql;

    /**
     * Constructor de la classe que inicialitza la connexió a la base de dades.
     *
     * @param \PDO $conn La connexió PDO a la base de dades.
     */
    public function __construct($conn)
    {
        // Inicialitza la propietat $sql amb la connexió proporcionada
        $this->sql = $conn;
    }


    /**
     * Obté totes les dades dels usuaris de la base de dades.
     *
     * @return array Un array associatiu amb les dades dels usuaris.
     */
    public function getAllUsers()
    {
        // Consulta SQL per seleccionar totes les columnes de la taula 'users'
        $sql = "SELECT * FROM users";

        // Preparació de la consulta
        $stmt = $this->sql->prepare($sql);

        // Execució de la consulta
        $stmt->execute();

        // Retorna totes les files com un array associatiu
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }





    /**
     * Obté les dades d'un usuari pel seu identificador.
     *
     * @param int $userId L'identificador de l'usuari.
     *
     * @return array|false Un array associatiu amb les dades de l'usuari o false si no es troba.
     */
    public function getUserById($userId)
    {
        // Consulta SQL per seleccionar totes les columnes de la taula 'users' on l'ID coincideixi
        $sql = "SELECT * FROM users WHERE id = ?";

        // Preparació de la consulta amb el paràmetre d'ID
        $stmt = $this->sql->prepare($sql);

        // Execució de la consulta amb l'ID proporcionat
        $stmt->execute([$userId]);

        // Retorna les dades de l'usuari com un array associatiu o false si no es troba cap usuari
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }



    /**
     * Funció que gestiona l'inici de sessió de l'usuari.
     *
     * @param string $email Correu electrònic de l'usuari.
     * @param string $password Contrasenya de l'usuari.
     *
     * @return array|null Les dades de l'usuari si l'inici de sessió és exitós, o null si no es troba l'usuari o la contrasenya no coincideix.
     */
    public function login($email, $password)
    {
        // Consulta SQL per obtenir les dades de l'usuari i el grup associat pel correu electrònic
        $sql = "SELECT u.*, ug.group_id FROM users u
            JOIN user_groups ug ON u.id = ug.user_id
            WHERE u.email = ?";

        // Preparació de la consulta amb el correu electrònic proporcionat
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$email]);

        // Obtenir les dades de l'usuari com un array associatiu
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Verificar si s'ha trobat un usuari i si la contrasenya coincideix
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        // Retorna null si no es troba l'usuari o la contrasenya no coincideix
        return null;
    }

    /**
     * Obté el nom del grup al qual pertany un usuari.
     *
     * @param int $userId L'identificador de l'usuari.
     *
     * @return string|null El nom del grup al qual pertany l'usuari o null si no té cap grup assignat.
     */
    public function getGroupForUser($userId)
    {
        // Consulta SQL per obtenir el nom del grup de l'usuari
        $query = "SELECT groups.name AS group_name 
              FROM user_groups
              JOIN `groups` ON user_groups.group_id = `groups`.id
              WHERE user_groups.user_id = :user_id";

        // Preparació de la consulta amb el paràmetre de l'ID d'usuari
        $statement = $this->sql->prepare($query);
        $statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);

        // Execució de la consulta
        $statement->execute();

        // Obtenció del nom del grup com un array associatiu
        $group = $statement->fetch(\PDO::FETCH_ASSOC);

        // Retorna el nom del grup o null si no té cap grup assignat
        return $group['group_name'] ?? null;
    }

    /**
     * Obté els identificadors dels grups als quals pertany un professor.
     *
     * @param int $userId L'identificador del professor.
     *
     * @return array Un array amb els identificadors dels grups als quals pertany el professor.
     */
    public function getGroupsProf($userId)
    {
        // Consulta SQL per obtenir els identificadors dels grups del professor
        $query = "SELECT group_id FROM user_groups WHERE user_id = :user_id";

        // Preparació de la consulta amb el paràmetre de l'ID del professor
        $statement = $this->sql->prepare($query);
        $statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);

        // Execució de la consulta
        $statement->execute();

        // Obtenció dels identificadors dels grups com un array associatiu
        $groups = $statement->fetchAll(\PDO::FETCH_ASSOC);

        // Retorna un array amb els identificadors dels grups als quals pertany el professor
        return array_column($groups, 'group_id');
    }


    /**
 * Obté el nom del grup al qual pertany un usuari.
 *
 * @param int $userId L'identificador de l'usuari.
 *
 * @return string|null El nom del grup al qual pertany l'usuari o null si no pertany a cap grup.
 */
public function getGroupByUserId($userId)
{
    // Consulta SQL per obtenir el nom del grup de l'usuari
    $query = "SELECT `groups`.name AS group_name, `groups`.id AS group_id
              FROM user_groups
              JOIN `groups` ON user_groups.group_id = `groups`.id
              WHERE user_groups.user_id = :user_id";

    // Preparació de la consulta amb el paràmetre de l'ID de l'usuari
    $statement = $this->sql->prepare($query);
    $statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);

    // Execució de la consulta
    $statement->execute();

    // Obtenció de les dades del grup com un array associatiu
    $group = $statement->fetch(\PDO::FETCH_ASSOC);
    
    // Retorna el nom del grup si existeix, sinó retorna null
    return $group['group_name'] ?? null;
}



    /**
     * Registra un nou usuari a la base de dades.
     *
     * @param string $name Nom de l'usuari.
     * @param string $surname Cognom de l'usuari.
     * @param string $email Correu electrònic de l'usuari.
     * @param string $phone Telèfon de l'usuari.
     * @param string $dni DNI de l'usuari.
     * @param string $birthDate Data de naixement de l'usuari.
     * @param string $role Rol de l'usuari.
     * @param string $password Contrasenya de l'usuari.
     *
     * @return int L'identificador del nou usuari inserit a la base de dades.
     */
    public function registerUser($name, $surname, $email, $phone, $dni, $birthDate, $role, $password)
    {
        // Pots ajustar aquesta consulta segons la teva estructura de taula
        $sql = "INSERT INTO users (name, surname, email, phone, dni, birth_date, role, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparació de la consulta amb els valors proporcionats
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$name, $surname, $email, $phone, $dni, $birthDate, $role, $password]);

        // Obtenció de l'identificador del nou usuari inserit
        $userId = $this->sql->lastInsertId();

        // Retorna l'identificador del nou usuari
        return $userId;
    }

    /**
     * Registra un nou usuari amb valors aleatoris a la base de dades.
     *
     * @param string $name Nom de l'usuari.
     * @param string $surname Cognom de l'usuari.
     * @param string $email Correu electrònic de l'usuari.
     * @param string $birthDate Data de naixement de l'usuari.
     * @param string $password Contrasenya de l'usuari.
     * @param string $role Rol de l'usuari.
     *
     * @return int L'identificador del nou usuari inserit a la base de dades.
     */
    public function registerRandomUser($name, $surname, $email, $birthDate, $password, $role)
    {
        // Pots ajustar aquesta consulta segons la teva estructura de taula
        $sql = "INSERT INTO users (name, surname, email, birth_date, password, role) VALUES (?, ?, ?, ?, ?, ?)";

        // Preparació de la consulta amb els valors proporcionats
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$name, $surname, $email, $birthDate, $password, $role]);

        // Obtenció de l'identificador del nou usuari inserit
        $userId = $this->sql->lastInsertId();

        // Retorna l'identificador del nou usuari
        return $userId;
    }



    /**
     * Assigna un usuari a un grup específic a la base de dades.
     *
     * @param int $userId L'identificador de l'usuari.
     * @param int $groupId L'identificador del grup al qual s'assignarà l'usuari.
     */
    public function assignUserToGroup($userId, $groupId)
    {
        // Consulta SQL per inserir l'usuari al grup
        $sql = "INSERT INTO user_groups (user_id, group_id) VALUES (?, ?)";

        // Preparació de la consulta amb els identificadors proporcionats
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId, $groupId]);
    }





    /**
     * Obté tots els grups de la base de dades.
     *
     * @return array Un array associatiu amb les dades de tots els grups.
     */
    public function getGroups()
    {
        // Consulta SQL per seleccionar totes les columnes de la taula 'groups'
        $sql = "SELECT * FROM `groups`";

        // Preparació de la consulta
        $stmt = $this->sql->prepare($sql);

        // Execució de la consulta
        $stmt->execute();

        // Retorna totes les files com un array associatiu
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obté tots els grups de la base de dades.
     *
     * @return array Un array associatiu amb les dades de tots els grups.
     */
    public function getAllGroups()
    {
        // Consulta SQL per seleccionar totes les columnes de la taula 'groups'
        $sql = "SELECT * FROM `groups`";

        // Preparació de la consulta
        $stmt = $this->sql->prepare($sql);

        // Execució de la consulta
        $stmt->execute();

        // Retorna totes les files com un array associatiu
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Obté tots els usuaris pertanyents a un grup específic de la base de dades.
     *
     * @param int $groupId L'identificador del grup.
     *
     * @return array Un array associatiu amb les dades de tots els usuaris del grup.
     */
    public function getUsersInGroup($groupId)
    {
        // Consulta SQL per seleccionar totes les dades dels usuaris pertanyents al grup
        $sql = "SELECT users.* FROM users
            JOIN user_groups ON users.id = user_groups.user_id
            WHERE user_groups.group_id = :group_id";

        // Preparació de la consulta amb el paràmetre de l'ID del grup
        $stmt = $this->sql->prepare($sql);
        $stmt->bindParam(':group_id', $groupId, \PDO::PARAM_INT);
        $stmt->execute();

        // Retorna totes les files com un array associatiu
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Obté tots els usuaris pertanyents a un grup específic de la base de dades.
     *
     * @param int $groupId L'identificador del grup.
     *
     * @return array Un array associatiu amb les dades de tots els usuaris del grup.
     */
    public function getAllUsersGrup($groupId)
    {
        // Consulta SQL per seleccionar totes les dades dels usuaris pertanyents al grup
        $sql = "SELECT users.* FROM users
            JOIN user_groups ON users.id = user_groups.user_id
            WHERE user_groups.group_id = :group_id";

        // Preparació de la consulta amb el paràmetre de l'ID del grup
        $stmt = $this->sql->prepare($sql);
        $stmt->bindParam(':group_id', $groupId, \PDO::PARAM_INT);
        $stmt->execute();

        // Retorna totes les files com un array associatiu
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Elimina un grup de la base de dades.
     *
     * @param int $groupId L'identificador del grup a eliminar.
     */
    public function deleteGrup($groupId)
    {
        // Primerament, eliminar de la taula user_groups
        $stm = $this->sql->prepare("DELETE FROM user_groups WHERE group_id = :group_id");
        $stm->execute([':group_id' => $groupId]);

        // Després, eliminar de la taula groups
        $stm = $this->sql->prepare("DELETE FROM `groups` WHERE id = :id");
        $stm->execute([':id' => $groupId]);
    }


    /**
     * Crea un nou grup a la base de dades.
     *
     * @param string $name El nom del nou grup.
     */
    public function crearGrup($name)
    {
        // Consulta SQL per inserir el nou grup amb el nom proporcionat
        $sql = "INSERT INTO `groups` (name) VALUES (?)";

        // Preparació de la consulta amb el nom del grup
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$name]);
    }



    /**
     * Edita les dades d'un usuari a la base de dades.
     *
     * @param int $id L'identificador de l'usuari a editar.
     * @param string $name El nou nom de l'usuari.
     * @param string $surname El nou cognom de l'usuari.
     * @param string $email El nou correu electrònic de l'usuari.
     * @param string $phone El nou telèfon de l'usuari.
     */
    public function editUser($id, $name, $surname, $email, $phone)
    {
        // Consulta SQL per actualitzar les dades de l'usuari amb l'ID proporcionat
        $stmt = $this->sql->prepare("UPDATE users SET name = :name, surname = :surname, email = :email, phone = :phone WHERE id = :id");

        // Execució de la consulta amb els nous valors
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':surname' => $surname,
            ':email' => $email,
            ':phone' => $phone
        ]);
    }


    /**
     * Edita les dades d'un usuari com a administrador a la base de dades.
     *
     * @param int $id L'identificador de l'usuari a editar.
     * @param string $name El nou nom de l'usuari.
     * @param string $surname El nou cognom de l'usuari.
     * @param string $email El nou correu electrònic de l'usuari.
     * @param string $phone El nou telèfon de l'usuari.
     * @param string $dni El nou DNI de l'usuari.
     * @param string $birth_date La nova data de naixement de l'usuari.
     * @param string $group_name El nom del nou grup de l'usuari.
     * @param string $role El nou rol de l'usuari.
     */
    public function editUserAdmin($id, $name, $surname, $email, $phone, $dni, $birth_date, $group_name, $role)
    {
        // Eliminar les assignacions existents del grup per a l'usuari
        $stmt = $this->sql->prepare("DELETE FROM user_groups WHERE user_id = :id");
        $stmt->execute([
            ':id' => $id
        ]);

        // Inserir la nova assignació del grup per a l'usuari
        $stmt = $this->sql->prepare("INSERT INTO user_groups (user_id, group_id) VALUES (:id, (SELECT id FROM `groups` WHERE name = :group_name))");
        $stmt->execute([
            ':id' => $id,
            ':group_name' => $group_name
        ]);

        // Actualitzar les dades de l'usuari amb els nous valors
        $stmt = $this->sql->prepare("UPDATE users SET name = :name, surname = :surname, email = :email, phone = :phone, dni = :dni, birth_date = :birth_date, role = :role WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':surname' => $surname,
            ':email' => $email,
            ':phone' => $phone,
            ':dni' => $dni,
            ':birth_date' => $birth_date,
            ':role' => $role
        ]);
    }

   /**
 * Actualitza les dades d'un usuari des de la interfície d'edició del panell.
 *
 * @param int $id L'identificador de l'usuari a editar.
 * @param string $name El nou nom de l'usuari.
 * @param string $surname El nou cognom de l'usuari.
 * @param string $email El nou correu electrònic de l'usuari.
 * @param string $phone El nou telèfon de l'usuari.
 * @param string $dni El nou DNI de l'usuari.
 * @param string $birth_date La nova data de naixement de l'usuari.
 * @param string $role El nou rol de l'usuari.
 */
public function PaneleditUser($id, $name, $surname, $email, $phone, $dni, $birth_date, $role)
{
    // Consulta SQL per actualitzar les dades de l'usuari amb l'ID proporcionat
    $stmt = $this->sql->prepare("UPDATE users SET name = :name, surname = :surname, email = :email, phone = :phone, dni = :dni, birth_date = :birth_date, role = :role WHERE id = :id");
    
    // Execució de la consulta amb els nous valors
    $stmt->execute([
        ':id' => $id,
        ':name' => $name,
        ':surname' => $surname,
        ':email' => $email,
        ':phone' => $phone,
        ':dni' => $dni,
        ':birth_date' => $birth_date,
        ':role' => $role
    ]);
}


/**
 * Obté totes les fotos associades a un usuari de la base de dades.
 *
 * @param int $userId L'identificador de l'usuari.
 *
 * @return array Un array associatiu amb les dades de totes les fotos de l'usuari.
 */
public function getUserPhotos($userId)
{
    // Consulta SQL per seleccionar totes les dades de les fotos de l'usuari
    $sql = "SELECT * FROM photo WHERE user_id = ?";
    
    // Preparació de la consulta amb l'ID de l'usuari
    $stmt = $this->sql->prepare($sql);
    
    // Execució de la consulta
    $stmt->execute([$userId]);

    // Retorna totes les files com un array associatiu
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


/**
 * Obté la foto seleccionada per a un usuari específic.
 *
 * @param int $userId Identificador de l'usuari.
 *
 * @return array Retorna un array associatiu amb les dades de la foto seleccionada o un array buit si no es troba cap coincidència.
 */
public function getUserSelectedPhoto($userId)
{
    // Consulta SQL per obtenir les dades de la foto seleccionada
    $sql = "SELECT * FROM photo WHERE user_id = ? AND selected_photo = 'active' LIMIT 1";

    // Preparació i execució de la consulta SQL
    $stmt = $this->sql->prepare($sql);
    $stmt->execute([$userId]);

    // Retorna les dades de la foto seleccionada com a array associatiu
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}




    /**
 * Desactiva totes les fotos d'un usuari a la base de dades.
 *
 * @param int $userId L'identificador de l'usuari.
 */
public function deactivateUserPhotos($userId)
{
    // Consulta SQL per actualitzar l'estat de les fotos de l'usuari a 'inactive'
    $sql = "UPDATE photo SET selected_photo = 'inactive' WHERE user_id = ?";
    
    // Preparació de la consulta amb l'ID de l'usuari
    $stmt = $this->sql->prepare($sql);
    
    // Execució de la consulta
    $stmt->execute([$userId]);
}


   /**
 * Activa una foto seleccionada d'un usuari a la base de dades.
 *
 * @param int $userId L'identificador de l'usuari.
 * @param int $selectedPhoto L'identificador de la foto seleccionada.
 */
public function activateSelectedPhoto($userId, $selectedPhoto)
{
    // Consulta SQL per actualitzar l'estat de la foto seleccionada a 'active'
    $sql = "UPDATE photo SET selected_photo = 'active' WHERE user_id = ? AND id = ?";
    
    // Preparació de la consulta amb els identificadors de l'usuari i la foto seleccionada
    $stmt = $this->sql->prepare($sql);
    
    // Execució de la consulta
    $stmt->execute([$userId, $selectedPhoto]);
}


   /**
 * Obté totes les fotos de la base de dades.
 *
 * @return array Un array associatiu amb les dades de totes les fotos.
 */
public function getAllPhotos()
{
    // Consulta SQL per seleccionar totes les dades de les fotos
    $sql = "SELECT * FROM photo";
    
    // Preparació de la consulta
    $stmt = $this->sql->prepare($sql);
    
    // Execució de la consulta
    $stmt->execute();

    // Retorna totes les files com un array associatiu
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}




   /**
 * Obté les dades dels alumnes associats a un professor de la base de dades.
 *
 * @param int $userId L'identificador del professor.
 *
 * @return array Un array associatiu amb les dades dels alumnes associats al professor.
 */
public function getAlumnesByProfessor($userId)
{
    // Consulta SQL per seleccionar les dades dels alumnes associats al professor
    $sql = "
        SELECT u.id AS user_id, u.name AS user_name, u.surname AS user_surname,
               u.email AS user_email, u.phone AS user_phone, u.dni AS user_dni,
               u.birth_date AS user_birth_date, u.role AS user_rol, g.name AS group_name, p.url AS photo_url
        FROM users u
        JOIN user_groups ug ON u.id = ug.user_id
        JOIN `groups` g ON ug.group_id = g.id
        LEFT JOIN photo p ON u.id = p.user_id AND p.selected_photo = 'active'
        WHERE ug.group_id IN (
            SELECT group_id
            FROM user_groups
            WHERE user_id = :userId
        )
        AND (u.role = 'Alumne' OR u.id = :userId)
    ";

    // Preparació de la consulta amb l'ID del professor
    $stmt = $this->sql->prepare($sql);
    $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
    
    // Execució de la consulta
    $stmt->execute();

    // Retorna totes les files com un array associatiu
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}




  /**
 * Crea una nova notificació d'error a la base de dades.
 *
 * @param int $userId L'identificador de l'usuari associat a l'error.
 * @param string $mensaje La descripció de l'error.
 */
public function createerror($userId, $mensaje)
{
    // Consulta SQL per inserir una nova notificació d'error amb l'usuari i el missatge proporcionats
    $sql = "INSERT INTO errornotifications (user_id, description) VALUES (?, ?)";
    
    // Preparació de la consulta amb l'ID de l'usuari i la descripció de l'error
    $stmt = $this->sql->prepare($sql);
    
    // Execució de la consulta
    $stmt->execute([$userId, $mensaje]);
}


   /**
 * Obté totes les notificacions d'error amb les dades associades a l'usuari de la base de dades.
 *
 * @return array Un array associatiu amb les dades de totes les notificacions d'error i els usuaris associats.
 */
public function geterror()
{
    // Consulta SQL per seleccionar les dades de les notificacions d'error i els usuaris associats
    $sql = "SELECT
                errornotifications.id AS error_id,
                errornotifications.user_id AS error_user_id,
                errornotifications.description AS error_description,
                errornotifications.status AS error_status,
                errornotifications.date AS error_date,
                users.id AS user_id,
                users.email AS user_email
            FROM
                errornotifications
            JOIN
                users ON errornotifications.user_id = users.id";

    // Preparació de la consulta
    $stmt = $this->sql->prepare($sql);
    
    // Execució de la consulta
    $stmt->execute();

    // Retorna totes les files com un array associatiu
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


   /**
 * Elimina una notificació d'error de la base de dades.
 *
 * @param int $errorId L'identificador de la notificació d'error a eliminar.
 */
public function deleteerror($errorId)
{
    // Consulta SQL per eliminar la notificació d'error amb l'ID proporcionat
    $stm = $this->sql->prepare("DELETE FROM errornotifications WHERE id = :error_id");
    
    // Execució de la consulta amb l'ID de la notificació d'error
    $stm->execute([':error_id' => $errorId]);
}

/**
 * Actualitza l'estat d'una notificació d'error a la base de dades.
 *
 * @param int $errorId L'identificador de la notificació d'error a actualitzar.
 * @param string $status El nou estat de la notificació d'error.
 */
public function uploadError($errorId, $status)
{
    // Consulta SQL per actualitzar l'estat de la notificació d'error amb l'ID proporcionat
    $sql = "UPDATE errornotifications SET status = :status WHERE id = :id";
    
    // Preparació de la consulta amb l'ID de la notificació d'error i el nou estat
    $stmt = $this->sql->prepare($sql);
    
    // Execució de la consulta amb els valors proporcionats
    $stmt->execute([
        ':id' => $errorId,
        ':status' => $status
    ]);
}


 /**
 * Obté la informació d'usuari i grup associada a un professor de la base de dades.
 *
 * @param int $userId L'identificador del professor.
 *
 * @return array Un array associatiu amb la informació de l'usuari i el grup associats al professor.
 */
public function IdPanel($userId)
{
    // Consulta SQL per seleccionar la informació de l'usuari i el grup associats al professor
    $stmt = $this->sql->prepare("SELECT u.id AS user_id, u.name, u.surname, g.id AS group_id, g.name
                                FROM users u
                                JOIN user_groups ug ON u.id = ug.user_id
                                JOIN `groups` g ON ug.group_id = g.id");

    // Execució de la consulta
    $stmt->execute();

    // Retorna el resultat com un array associatiu
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * Elimina un usuari i les seves associacions a les altres taules de la base de dades.
 *
 * @param int $userId L'identificador de l'usuari a eliminar.
 */
public function deleteUser($userId)
{
    // Elimina de la taula 'photo' amb l'ID de l'usuari
    $stm = $this->sql->prepare("DELETE FROM photo WHERE user_id = :user_id");
    $stm->execute([':user_id' => $userId]);

    // Elimina de la taula 'orla_users' amb l'ID de l'usuari
    $stm = $this->sql->prepare("DELETE FROM orla_users WHERE user_id = :user_id");
    $stm->execute([':user_id' => $userId]);

    // Elimina de la taula 'user_groups' amb l'ID de l'usuari
    $stm = $this->sql->prepare("DELETE FROM user_groups WHERE user_id = :user_id");
    $stm->execute([':user_id' => $userId]);

    // Elimina de la taula 'users' amb l'ID de l'usuari
    $stm = $this->sql->prepare("DELETE FROM users WHERE id = :id");
    $stm->execute([':id' => $userId]);
}





    /**
 * Pujar una foto de perfil des d'un fitxer per a un usuari específic a la base de dades.
 *
 * @param int $userId L'identificador de l'usuari al qual es carregarà la foto.
 * @param string $photoUrl La URL de la foto a carregar.
 * @param string $selectedPhoto Indica si la foto és la seleccionada ('active') o no ('inactive').
 */
public function uploadPhotoFromFile($userId, $photoUrl, $selectedPhoto)
{
    // Consulta SQL per inserir una nova foto de perfil amb l'ID d'usuari, la URL i l'estat de selecció
    $sql = "INSERT INTO photo (user_id, url, selected_photo) VALUES (?, ?, ?)";
    
    // Preparació de la consulta amb els valors proporcionats
    $stmt = $this->sql->prepare($sql);
    
    // Execució de la consulta amb els valors proporcionats
    $stmt->execute([$userId, $photoUrl, $selectedPhoto]);
}

/**
 * Guarda el token d'un usuari a la base de dades.
 *
 * @param int $userId L'identificador de l'usuari al qual es guardarà el token.
 * @param string $token El token a guardar per a l'usuari.
 *
 * @return bool Retorna true si l'actualització va ser exitosa, sinó retorna false.
 */
public function saveUserToken($userId, $token)
{
    try {
        // Preparació de la consulta SQL per actualitzar el token de l'usuari
        $stmt = $this->sql->prepare("UPDATE users SET token = :token WHERE id = :userId");
        
        // Assignació dels valors als marcadors de posició
        $stmt->bindParam(":token", $token, \PDO::PARAM_STR);
        $stmt->bindParam(":userId", $userId, \PDO::PARAM_INT);
        
        // Execució de la consulta
        $stmt->execute();

        // Retorna true si l'actualització va ser exitosa
        return true;
    } catch (\PDOException $e) {
        // Maneig d'errors: Pots ajustar-ho segons les teves necessitats
        echo "Error al guardar el token: " . $e->getMessage();
        return false;
    }
}

/**
 * Obtiene el token de autenticación de un usuario según su identificador.
 *
 * @param int $userId El identificador del usuario.
 *
 * @return string|null El token de autenticación del usuario o null si no se encuentra.
 */
public function getUserToken($userId)
{
    try {
        // Prepara la consulta SQL para obtener el token del usuario
        $stmt = $this->sql->prepare("SELECT token FROM users WHERE id = :userId");
        $stmt->bindParam(":userId", $userId, \PDO::PARAM_INT);
        $stmt->execute();

        // Obtiene el resultado de la consulta
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Retorna el token si existe, de lo contrario, retorna null
        return $result ? $result['token'] : null;
    } catch (\PDOException $e) {
        // Manejo de errores: Puedes ajustar esto según tus necesidades
        echo "Error al obtener el token del usuario: " . $e->getMessage();
        return null;
    }
}




 /**
 * Obté un usuari mitjançant el seu token d'accés a la base de dades.
 *
 * @param string $token El token d'accés de l'usuari.
 *
 * @return array|false Retorna un array associatiu amb la informació de l'usuari si es troba, o false si no es troba.
 */
public function getUserByToken($token)
{
    // Consulta SQL per seleccionar un usuari amb el token proporcionat
    $query = "SELECT * FROM users WHERE token = :token";
    
    // Preparació de la consulta amb el token proporcionat
    $stmt = $this->sql->prepare($query);
    $stmt->bindParam(":token", $token, \PDO::PARAM_STR);
    
    // Execució de la consulta
    $stmt->execute();

    // Retorna l'usuari si es troba, o false si no es troba
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

/**
 * Verifica si un correu electrònic ja existeix a la base de dades.
 *
 * @param string $email L'adreça de correu electrònic a verificar.
 *
 * @return array|false Retorna un array associatiu amb la informació de l'usuari si ja existeix, o false si no existeix.
 */
public function emailExists($email)
{
    // Consulta SQL per verificar si l'adreça de correu electrònic ja existeix
    $query = "SELECT * FROM users WHERE email = :email";
    
    // Preparació de la consulta amb l'adreça de correu electrònic proporcionada
    $stmt = $this->sql->prepare($query);
    $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
    
    // Execució de la consulta
    $stmt->execute();

    // Retorna l'usuari si ja existeix, o false si no existeix
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}


/**
 * Envia un correu electrònic per a la recuperació de contrasenya.
 *
 * @param string $email L'adreça de correu electrònic del destinatari.
 */
public function RecoveryEmail($email)
{
    // Instància de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuració del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'Orlify22@gmail.com';
        $mail->Password = 'dqdi lybq lqhz dydb';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configuració del remitent i destinatari
        $mail->setFrom('marcos01092004@gmail.com', 'mmunoz2');
        $mail->addAddress($email);

        // Configuració del contingut del correu com a HTML
        $mail->isHTML(true);
        $mail->Subject = 'Recuperacio de contrasenya';

        // Cos HTML amb l'enllaç
        $htmlBody = '<p>Hem rebut una sol·licitud per restablir la teva contrasenya. Si us plau, segueix les instruccions que rebràs per correu.</p>';
        $htmlBody .= '<p>Accedeix a aquest <a href="http://localhost:8080/newpass">enllaç</a> per establir la teva nova contrasenya.</p>';

        $mail->msgHTML($htmlBody);

        // Envia el correu electrònic
        $mail->send();
    } catch (Exception $e) {
        echo "Error en enviar el correu: {$mail->ErrorInfo}";
    }
}


   /**
 * Emmagatzema un token associat a un correu electrònic d'usuari.
 *
 * @param string $email L'adreça de correu electrònic de l'usuari.
 * @param string $token El token a emmagatzemar.
 */
public function storeToken($email, $token)
{
    // Preparació de la consulta per actualitzar el token associat a un correu electrònic
    $stmt = $this->sql->prepare("UPDATE users SET token = :token WHERE email = :email");
    
    // Assignació dels valors als paràmetres de la consulta
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':email', $email);
    
    // Execució de la consulta
    $stmt->execute();
}

   /**
 * Actualitza la contrasenya d'un usuari a la base de dades.
 *
 * @param int $id L'identificador de l'usuari.
 * @param string $password La nova contrasenya encriptada.
 */
public function PasswordUser($id, $password)
{
    // Preparació de la consulta per actualitzar la contrasenya d'un usuari
    $stmt = $this->sql->prepare("UPDATE users SET password = :password  WHERE id = :id");
    
    // Assignació dels valors als paràmetres de la consulta
    $stmt->execute([
        ':id' => $id,
        ':password' => $password
    ]);
}

   /**
 * Obte un usuari basat en l'adreça de correu electrònic.
 *
 * @param string $email L'adreça de correu electrònic de l'usuari a cercar.
 * @return array|false Retorna un array amb les dades de l'usuari si es troba, o false si no es troba.
 */
public function getUserByEmail($email)
{
    // Consulta SQL per obtenir l'usuari pel seu correu electrònic
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $this->sql->prepare($query);
    $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
    $stmt->execute();

    // Retorna l'usuari si es troba, o false si no es troba
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

/**
 * Obte el token associat a un usuari pel seu correu electrònic.
 *
 * @param string $email L'adreça de correu electrònic de l'usuari.
 * @return string|false Retorna el token de l'usuari si es troba, o false si no es troba.
 */
public function getTokenByEmail($email)
{
    // Consulta SQL per obtenir el token d'un usuari pel seu correu electrònic
    $query = "SELECT token FROM users WHERE email = :email";
    $stmt = $this->sql->prepare($query);
    $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
    $stmt->execute();

    // Obté el resultat de la consulta
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);

    // Retorna el token si es troba, o false si no es troba
    return ($result !== false) ? $result['token'] : false;
}
}