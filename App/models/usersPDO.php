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
}
