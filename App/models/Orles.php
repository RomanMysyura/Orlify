<?php

namespace App\Models;

class Orles
{
    private $sql;

    public function __construct($conn)
    {
        $this->sql = $conn;
    }
   
/**
 * Funció per obtenir les orles associades a un usuari
 *
 * @param   int  $user_id  ID de l'usuari
 *
 * @return  array           Array amb les dades de les orles associades a l'usuari
 */

 public function getOrles($user_id)
 {
     // Obtenir els grups als quals pertany l'usuari
     $group_ids = $_SESSION["grup_prof"];
 
     // Crear una cadena de marcadors de posición per a la clàusula WHERE IN
     $placeholders = implode(', ', array_map(function ($id) {
         return ":group_id_$id";
     }, $group_ids));
 
     $stmt = $this->sql->prepare("SELECT u.id AS user_id, u.name, u.surname, o.id AS orla_id, o.status, o.url, o.name_orla
                                 FROM users u
                                 JOIN user_groups ug ON u.id = ug.user_id
                                 JOIN groups g ON ug.group_id = g.id
                                 JOIN orla o ON g.id = o.group_id
                                 WHERE u.id = :user_id
                                   AND g.id IN ($placeholders)");
 
     $stmt->bindParam(":user_id", $user_id);
 
     foreach ($group_ids as $id) {
         $stmt->bindValue(":group_id_$id", $id);
     }
 
     try {
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    } catch (\PDOException $e) {
        // Manejar el error aquí
        die("Error en la ejecución de la consulta: " . $e->getMessage());
    }
    
 
     $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
 
     return $result;
 }
 
    
    

  /**
 * Funció per obtenir les dades d'una orla segons el seu ID
 *
 * @param   int  $orla_id  ID de l'orla
 *
 * @return  array           Array amb les dades de l'orla
 */

    public function getOrlaById($orla_id)
{
    $stmt = $this->sql->prepare("SELECT * FROM orla WHERE id = :orla_id");
    $stmt->bindParam(":orla_id", $orla_id);
    $stmt->execute();
    
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result;
}


/**
 * Funció per obtenir totes les orles amb les seves dades associades
 *
 * @return  array  Array amb les dades de totes les orles
 */
    public function getAllOrles()
    {
        $stmt = $this->sql->prepare("SELECT o.id AS orla_id, o.status, o.url, o.name_orla, g.name AS group_name, g.id AS group_id
                                    FROM orla o
                                    JOIN groups g ON o.group_id = g.id");
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    /**
 * Funció per obtenir totes les fotos associades a una orla
 *
 * @param   int  $orla_id  ID de l'orla
 *
 * @return  array           Array amb les dades de les fotos de l'orla
 */
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

    
    /**
 * Funció per obtenir els usuaris associats a una orla
 *
 * @param   int  $orla_id  ID de l'orla
 *
 * @return  array           Array amb els IDs d'usuaris associats a l'orla
 */ 
    public function getUsersInOrla($orla_id)
    {
        $stmt = $this->sql->prepare("SELECT user_id FROM orla_users WHERE orla_id = :orla_id");
        $stmt->bindParam(":orla_id", $orla_id);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    
    
    /**
 * Funció per obtenir el nom d'una orla pel seu ID
 *
 * @param   int  $orla_id  ID de l'orla
 *
 * @return  string         Nom de l'orla
 */
    public function getOrlaName($orla_id)
    {
        $stmt = $this->sql->prepare("SELECT name_orla FROM orla WHERE id = :orla_id");
        $stmt->bindParam(":orla_id", $orla_id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result["name_orla"];
    }


    /**
 * Funció per obtenir l'estat d'una orla pel seu ID
 *
 * @param   int  $orla_id  ID de l'orla
 *
 * @return  string         Estat de l'orla
 */
    public function getStatusOrla($orla_id)
{
    $stmt = $this->sql->prepare("SELECT status FROM orla WHERE id = :orla_id");
    $stmt->bindParam(":orla_id", $orla_id);
    $stmt->execute();
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result["status"]; // Corregido: "status" en lugar de "orlaStatus"
}




/**
 * Funció per publicar o despublicar una orla
 *
 * @param   int  $orlaId  ID de l'orla
 */
public function publishOrla($orlaId)
{
    $stmtSelect = $this->sql->prepare("SELECT status FROM orla WHERE id = :orlaId");
    $stmtSelect->bindParam(":orlaId", $orlaId);
    $stmtSelect->execute();
    
   
    $currentStatus = $stmtSelect->fetchColumn();

    $newStatus = ($currentStatus === 'Privat') ? 'Public' : 'Privat';

    $stmtUpdate = $this->sql->prepare("UPDATE orla SET status = :status WHERE id = :orlaId");
    $stmtUpdate->bindParam(":status", $newStatus);
    $stmtUpdate->bindParam(":orlaId", $orlaId);
    $stmtUpdate->execute();
}


/**
 * Crea una nova orla associada al grup de la sessió actual.
 * Si no s'ha definit 'group_id' a la sessió, mostra un missatge d'error.
 */
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
    

    /**
 * Obté les fotos associades a una orla específica.
 *
 * @param   int  $orla_id  ID de la orla
 *
 * @return  array           Fotos de la orla
 */
    public function getPhotosForOrla($orla_id)
    {
        $stmt = $this->sql->prepare("SELECT p.id AS photo_id, u.name AS user_name, u.surname, p.url, u.role
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
    
    /**
 * Elimina una orla i tots els seus registres associats a la base de dades.
 *
 * @param   int  $orla_id  ID de la orla a eliminar
 */
    public function eliminarOrla($orla_id)
    {
        $stmtOrlaUsers = $this->sql->prepare("DELETE FROM orla_users WHERE orla_id = :orla_id");
        $stmtOrlaUsers->bindParam(":orla_id", $orla_id);
        $stmtOrlaUsers->execute();
    
        $stmtOrla = $this->sql->prepare("DELETE FROM orla WHERE id = :orla_id");
        $stmtOrla->bindParam(":orla_id", $orla_id);
        $stmtOrla->execute();
    
    }

    /**
 * Elimina una foto específica de la base de dades.
 *
 * @param   int  $photo_id  ID de la foto a eliminar
 */
public function eliminarPhoto($photo_id){
        
        $stmt = $this->sql->prepare("DELETE FROM photo WHERE id = :photo_id");
        $stmt->bindParam(":photo_id", $photo_id);
        $stmt->execute();
}
 
/**
 * Actualitza els detalls d'una orla existent.
 *
 * @param   int     $orla_id    ID de l'orla a actualitzar
 * @param   string  $name_orla  Nou nom de l'orla
 * @param   string  $status     Nou estat de l'orla
 * @param   string  $url        Nova URL de l'orla
 * @param   string  $group_name Nom del grup associat a l'orla
 */
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

    

/**
 * Afegeix usuaris a una orla específica.
 *
 * @param   int    $orla_id        ID de l'orla a la qual s'afegeixen els usuaris
 * @param   array  $selected_users Usuaris seleccionats per afegir a l'orla
 */
    public function addUsersToOrla($orla_id, $selected_users)
    {
        $stmtDelete = $this->sql->prepare("DELETE FROM orla_users WHERE orla_id = :orla_id");
        $stmtDelete->bindParam(":orla_id", $orla_id);
        $stmtDelete->execute();
    
        foreach ($selected_users as $user_id) {
            $stmtInsert = $this->sql->prepare("INSERT INTO orla_users (user_id, orla_id) VALUES (:user_id, :orla_id)");
            $stmtInsert->bindParam(":user_id", $user_id);
            $stmtInsert->bindParam(":orla_id", $orla_id);
            $stmtInsert->execute();
        }
    }
    
    
   /**
 * Actualitza el nom d'una orla existent.
 *
 * @param   int     $orla_id    ID de l'orla a actualitzar
 * @param   string  $name_orla  Nou nom de l'orla
 */
    public function UploadNameOrla($orla_id, $name_orla)
    {
        $stmt = $this->sql->prepare("UPDATE orla SET name_orla = :name_orla WHERE id = :orla_id");
        $stmt->bindParam(":orla_id", $orla_id);
        $stmt->bindParam(":name_orla", $name_orla);
        $stmt->execute();
    }


    
}