<?php

use \Emeset\Contracts\Http\Request;
use \Emeset\Contracts\Http\Response;
use \Emeset\Contracts\Container;

/**
 * Controlador de la portada d'exemple del Framework Emeset
 * Framework d'exemple per a M07 Desenvolupament d'aplicacions web.
 * @author: Dani Prados dprados@cendrassos.net
 *
 * Carrega la portada
 *
 **/

/**
 * ctrlPortada: Controlador que carrega  la portada
 *
 * @param $request contingut de la petiicó http.
 * @param $response contingut de la response http.
 * @param array $config  paràmetres de configuració de l'aplicació
 *
 **/
function ctrlPortada(Request $request, Response $response, Container $container): Response
{
    // Comptem quantes vegades has visitat aquesta pàgina
    $visites = $request->get(INPUT_COOKIE, "visites");
    if (!is_null($visites)) {
        $visites = (int)$visites + 1;
    } else {
        $visites = 1;
    }
    $response->setcookie("visites", $visites, strtotime("+1 month"));

    $missatge = "";
    if ($visites == 1) {
        $missatge = "Benvingut! Aquesta és la primera pàgina que visites d'aquesta web!";
    } else {
        $missatge = "Hola! Ja has visitat {$visites} pàgines d'aquesta web!";
    }

    // Conectar a la base de datos y realizar la consulta con PDO
    $servername = $container["config"]["database"]["server"];
    $username = $container["config"]["database"]["username"];
    $password = $container["config"]["database"]["password"];
    $database = $container["config"]["database"]["database"];

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Realizar la consulta
        $sql = "SELECT * FROM users";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // Obtener los resultados
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pasar los datos a la vista
        $response->set("users", $users);

    } catch (PDOException $e) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }

    $response->set("missatge", $missatge);
    $response->SetTemplate("index.php");

    return $response;
}
