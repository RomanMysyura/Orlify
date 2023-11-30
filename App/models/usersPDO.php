<?php

namespace App\Models;

class UsersPDO
{
    private $sql;

    public function __construct($conn)
    {
        $this->sql = $conn;
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }




    public function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    
    public function login($email, $password)
    {
        $sql = "SELECT u.*, ug.group_id FROM users u
            JOIN user_groups ug ON u.id = ug.user_id
            WHERE u.email = ?";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Verifica si se encontró un usuario y si la contraseña coincide
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }
    public function getGroupForUser($userId)
    {
        // Consulta para obtener el grupo del usuario
        $query = "SELECT groups.name AS group_name 
              FROM user_groups
              JOIN groups ON user_groups.group_id = groups.id
              WHERE user_groups.user_id = :user_id";

        $statement = $this->sql->prepare($query);
        $statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();
        $group = $statement->fetch(\PDO::FETCH_ASSOC);
        
        return $group['group_name'] ?? null;
        
    }

    public function registerUser($name, $surname, $email, $phone, $dni, $birthDate, $password)
    {
        // Puedes ajustar esta consulta según tu estructura de tabla
        $sql = "INSERT INTO users (name, surname, email, phone, dni, birth_date, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$name, $surname, $email, $phone, $dni, $birthDate, $password]);
        $userId = $this->sql->lastInsertId();

        return $userId;
    }
    public function registerRandomUser($name, $surname, $email, $birthDate, $password, $role)
    {
        // Puedes ajustar esta consulta según tu estructura de tabla
        $sql = "INSERT INTO users (name, surname, email, birth_date, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$name, $surname, $email, $birthDate, $password, $role]);
        $userId = $this->sql->lastInsertId();

        return $userId;
    }

    
    public function assignUserToGroup($userId, $groupId)
    {
        $sql = "INSERT INTO user_groups (user_id, group_id) VALUES (?, ?)";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId, $groupId]);
    }




    public function getGroups()
    {
        $sql = "SELECT * FROM groups";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllGroups()
    {
        $sql = "SELECT * FROM groups";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUsersInGroup($groupId)
    {
        $sql = "SELECT users.* FROM users
                JOIN user_groups ON users.id = user_groups.user_id
                WHERE user_groups.group_id = :group_id";
    
        $stmt = $this->sql->prepare($sql);
        $stmt->bindParam(':group_id', $groupId, \PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function editUser($id, $name, $surname, $email, $phone)
    {

        $stmt = $this->sql->prepare("UPDATE users SET name = :name, surname = :surname, email = :email, phone = :phone WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':surname' => $surname,
            ':email' => $email,
            ':phone' => $phone
        ]);
    }

    public function editUserAdmin($id, $name, $surname, $email, $phone, $dni, $birth_date, $role)
    {

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

    public function PaneleditUser($id, $name, $surname, $email, $phone,$dni,$birth_date,$role)
    {

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

    public function getUserPhotos($userId)
    {
        $sql = "SELECT * FROM photo WHERE user_id = ?";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserSelectedPhoto($userId)
    {
        $sql = "SELECT * FROM photo WHERE user_id = ? AND selected_photo = 'active'";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
 

    public function deactivateUserPhotos($userId)
    {
        $sql = "UPDATE photo SET selected_photo = 'inactive' WHERE user_id = ?";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId]);
    }
    
    public function activateSelectedPhoto($userId, $selectedPhoto)
    {
        $sql = "UPDATE photo SET selected_photo = 'active' WHERE user_id = ? AND id = ?";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId, $selectedPhoto]);
    }
    

   
    public function getAlumnesByProfessor($userId)
    {
        $sql = "
            SELECT u.id AS user_id, u.name AS user_name, u.surname AS user_surname,
                   u.email AS user_email, u.phone AS user_phone, u.dni AS user_dni,
                   u.birth_date AS user_birth_date, g.name AS group_name, p.url AS photo_url
            FROM users u
            JOIN user_groups ug ON u.id = ug.user_id
            JOIN groups g ON ug.group_id = g.id
            LEFT JOIN photo p ON u.id = p.user_id AND p.selected_photo = 'active'
            WHERE ug.group_id IN (
                SELECT group_id
                FROM user_groups
                WHERE user_id = :userId
            )
            AND u.role = 'Alumne'
        ";
    
        $stmt = $this->sql->prepare($sql);
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    


    public function createerror($userId, $mensaje)
    {
        $sql = "INSERT INTO errornotifications (user_id, description) VALUES (?, ?)";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId, $mensaje]);
    }

  public function geterror()
    {
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
        users ON errornotifications.user_id = users.id;)";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteerror($errorId){
        $stm = $this->sql->prepare("DELETE FROM errornotifications WHERE id = :error_id");
        $stm->execute([':error_id' => $errorId]);
    }

    public function uploadError($errorId, $status)
    {
        $sql = "UPDATE errornotifications SET status = :status WHERE id = :id";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([
            ':id' => $errorId,
            ':status' => $status
        ]);
    }

    public function IdPanel($userId)
    {
        $stmt = $this->sql->prepare("SELECT u.id AS user_id, u.name, u.surname, g.id AS group_id, g.name
                                        FROM users u
                                        JOIN user_groups ug ON u.id = ug.user_id
                                        JOIN groups g ON ug.group_id = g.id");
        
        $stmt->execute();
        
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $result;
    }
    

    public function deleteUser($userid){

        // Primero, eliminar de la tabla photo
        $stm = $this->sql->prepare("DELETE FROM photo WHERE user_id = :user_id");
        $stm->execute([':user_id' => $userid]);

        // Primero, eliminar de la tabla orla_users
        $stm = $this->sql->prepare("DELETE FROM orla_users WHERE user_id = :user_id");
        $stm->execute([':user_id' => $userid]);

        // Primero, eliminar de la tabla user_groups
        $stm = $this->sql->prepare("DELETE FROM user_groups WHERE user_id = :user_id");
        $stm->execute([':user_id' => $userid]);
    
        // Luego, eliminar de la tabla users
        $stm = $this->sql->prepare("DELETE FROM users WHERE id = :id");
        $stm->execute([':id' => $userid]);
    }

   


    public function uploadPhotoFromFile($userId, $photoUrl, $selectedPhoto)
    {
        $sql = "INSERT INTO photo (user_id, url, selected_photo) VALUES (?, ?, ?)";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId, $photoUrl, $selectedPhoto]);
    }
    

    public function saveUserToken($userid, $token)
    {
        try {
            // Prepara la consulta SQL
            $stmt = $this->sql->prepare("UPDATE users SET token = :token WHERE id = :userId");
            // Asigna los valores a los marcadores de posición
            $stmt->bindParam(":token", $token, \PDO::PARAM_STR);
            $stmt->bindParam(":userId", $userid, \PDO::PARAM_INT);  // Asegúrate de que sea "userId" en lugar de "userid"
    
            // Ejecuta la consulta
            $stmt->execute();
    
            // Devuelve true si la actualización fue exitosa
            return true;
        } catch (PDOException $e) {
            // Manejo de errores: Puedes ajustar esto según tus necesidades
            echo "Error al guardar el token: " . $e->getMessage();
            return false;
        }
    }
    

    public function getUserToken($userId) {
        try {
            // Prepara la consulta SQL para obtener el token del usuario
            $stmt = $this->sql->prepare("SELECT token FROM users WHERE id = :userId");
            $stmt->bindParam(":userId", $userId, \PDO::PARAM_INT);
            $stmt->execute();

            // Obtiene el resultado de la consulta
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Retorna el token si existe, de lo contrario, retorna null
            return $result ? $result['token'] : null;
        } catch (PDOException $e) {
            // Manejo de errores: Puedes ajustar esto según tus necesidades
            echo "Error al obtener el token del usuario: " . $e->getMessage();
            return null;
        }
    }
    public function getUserByToken($token)
{
    $query = "SELECT * FROM users WHERE token = :token";
    $stmt = $this->sql->prepare($query);
    $stmt->bindParam(":token", $token, \PDO::PARAM_STR);
    $stmt->execute();

    // Devuelve el usuario si se encuentra, o false si no se encuentra
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
}