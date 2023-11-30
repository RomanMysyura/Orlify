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
        $stmt = $this->sql->prepare("SELECT u.id AS user_id, u.name, u.surname, o.id AS orla_id, o.status, o.url, o.name_orla
                                    FROM users u
                                    JOIN user_groups ug ON u.id = ug.user_id
                                    JOIN groups g ON ug.group_id = g.id
                                    JOIN orla o ON g.id = o.group_id
                                    WHERE u.id = :user_id ");
        $stmt->bindParam(":user_id", $user_id);
    
        $stmt->execute();
    
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        return $result;
    }

    public function getAllOrles()
    {
        $stmt = $this->sql->prepare("SELECT o.id AS orla_id, o.status, o.url, o.name_orla, g.name AS group_name, g.id AS group_id
                                    FROM orla o
                                    JOIN groups g ON o.group_id = g.id");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

   public function getAllPhotosOrla($orla_id)
    {
        $stmt = $this->sql->prepare("SELECT p.id AS photo_id, p.name, p.url
                                    FROM photo p
                                    JOIN users u ON p.user_id = u.id
                                    JOIN orla_users ou ON u.id = ou.user_id
                                    JOIN orla o ON ou.orla_id = o.id
                                    WHERE o.id = :orla_id");
        $stmt->bindParam(":orla_id", $orla_id);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    

    public function createNewOrla()
    {
       
    
    
        if (isset($_SESSION["group_id"])) {
            $group_id = $_SESSION["group_id"];
    
            $sql = "INSERT INTO `orla`(`group_id`) VALUES (?)";
            $stmt = $this->sql->prepare($sql);
            $stmt->execute([$group_id]);
        } else {
           
            echo "Error: No se ha definido group_id en la sesión.";
        }
    }
    

    public function getPhotosForOrla($orla_id)
    {
        $stmt = $this->sql->prepare("SELECT p.id AS photo_id, p.name, p.url
                                    FROM photo p
                                    JOIN users u ON p.user_id = u.id
                                    JOIN orla_users ou ON u.id = ou.user_id
                                    JOIN orla o ON ou.orla_id = o.id
                                    WHERE o.id = :orla_id AND p.selected_photo = 'active'");
        $stmt->bindParam(":orla_id", $orla_id);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    
    
    public function eliminarOrla($orla_id)
    {
        // Eliminar registros de orla_users asociados a la orla
        $stmtOrlaUsers = $this->sql->prepare("DELETE FROM orla_users WHERE orla_id = :orla_id");
        $stmtOrlaUsers->bindParam(":orla_id", $orla_id);
        $stmtOrlaUsers->execute();
    
        // Ahora puedes eliminar la orla de la tabla orla
        $stmtOrla = $this->sql->prepare("DELETE FROM orla WHERE id = :orla_id");
        $stmtOrla->bindParam(":orla_id", $orla_id);
        $stmtOrla->execute();
    
        // Redireccionar o retornar según sea necesario
    }

public function eliminarPhoto($photo_id){
        
        $stmt = $this->sql->prepare("DELETE FROM photo WHERE id = :photo_id");
        $stmt->bindParam(":photo_id", $photo_id);
        $stmt->execute();
}
    
   public function UploadOrla($orla_id, $name_orla, $status, $url, $group_name)
    {
        $stmt = $this->sql->prepare("UPDATE orla SET name_orla = :name_orla, status = :status, url = :url, group_id  = (SELECT id FROM groups WHERE name = :group_name) WHERE id = :orla_id");
        $stmt->bindParam(":orla_id", $orla_id);
        $stmt->bindParam(":name_orla", $name_orla);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":url", $url);
        $stmt->bindParam(":group_name", $group_name);
        $stmt->execute();
    }

    


    public function addUsersToOrla($orla_id, $selected_users)
    {
        // Eliminar todos los usuarios asociados a la orla
        $stmtDelete = $this->sql->prepare("DELETE FROM orla_users WHERE orla_id = :orla_id");
        $stmtDelete->bindParam(":orla_id", $orla_id);
        $stmtDelete->execute();
    
        // Iterar sobre los usuarios seleccionados y realizar la inserción en la tabla orla_users
        foreach ($selected_users as $user_id) {
            $stmtInsert = $this->sql->prepare("INSERT INTO orla_users (user_id, orla_id) VALUES (:user_id, :orla_id)");
            $stmtInsert->bindParam(":user_id", $user_id);
            $stmtInsert->bindParam(":orla_id", $orla_id);
            $stmtInsert->execute();
        }
    }
    
    
    
    


    
}
