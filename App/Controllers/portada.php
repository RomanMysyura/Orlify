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

    // Conectar a la base de datos y realizar la consulta
    $servername = $container["config"]["database"]["server"];
    $username = $container["config"]["database"]["username"];
    $password = $container["config"]["database"]["password"];
    $database = $container["config"]["database"]["database"];

    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Realizar la consulta
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Convertir los resultados en un array asociativo
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        // Pasar los datos a la vista
        $response->set("users", $users);
    } else {
        $response->set("users", []);
    }

    // Cerrar la conexión
    $conn->close();

    $response->set("missatge", $missatge);
    $response->SetTemplate("index.php");

    return $response;
}
