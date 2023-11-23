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


    public function registerUser($name, $surname, $email, $birthDate, $password)
    {
        // Puedes ajustar esta consulta según tu estructura de tabla
        $sql = "INSERT INTO users (name, surname, email, birth_date, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$name, $surname, $email, $birthDate, $password]);
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
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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



    public function editUser($id, $name, $surname, $email) {
    
        $stmt = $this->sql->prepare("UPDATE users SET name = :name, surname = :surname, email = :email WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':surname' => $surname,
            ':email' => $email
        ]);
    }
    
    public function getUserPhotos($userId)
    {
        $sql = "SELECT * FROM photo WHERE user_id = ?";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}