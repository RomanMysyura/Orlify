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
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $this->sql->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch(\PDO::FETCH_ASSOC);

    // Verifica si se encontró un usuario y si la contraseña coincide
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}

    public function registerUser($name, $surname, $email, $birthDate, $password)
    {
        // Puedes ajustar esta consulta según tu estructura de tabla
        $sql = "INSERT INTO users (name, surname, email, birth_date, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->sql->prepare($sql);
        $stmt->execute([$name, $surname, $email, $birthDate, $password]);
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
    
}