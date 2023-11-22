<?php

namespace App\Models;

class Orles
{
    private $sql;

    public function __construct($conn)
    {
        $this->sql = $conn;
    }

    public function getOrles($user_id)
    {
        $stmt = $this->sql->prepare("SELECT u.id AS user_id, u.name, u.surname, o.id AS orla_id, o.status, o.url
                                    FROM users u
                                    JOIN user_groups ug ON u.id = ug.user_id
                                    JOIN groups g ON ug.group_id = g.id
                                    JOIN orla o ON g.id = o.group_id
                                    WHERE u.id = :user_id ");
        $stmt->bindParam(":user_id", $user_id);

        // Ejecuta la consulta
        $stmt->execute();

        // Recupera los resultados después de ejecutar la consulta
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getPhotosForOrla($orla_id)
    {
        $stmt = $this->sql->prepare("SELECT p.id AS photo_id, p.name, p.url
                                    FROM photo p
                                    JOIN users u ON p.user_id = u.id
                                    JOIN user_groups ug ON u.id = ug.user_id
                                    JOIN groups g ON ug.group_id = g.id
                                    JOIN orla o ON g.id = o.group_id
                                    WHERE o.id = :orla_id");
        $stmt->bindParam(":orla_id", $orla_id);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}
