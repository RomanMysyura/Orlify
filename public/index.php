<?php

/**
 * Front controler
 * Exemple de MVC per a M07 Desenvolupament d'aplicacions web en entorn de servidor.
 * Aquest Framework implementa el mínim per tenir un MVC per fer pràctiques..
 * de M07.
 * @author: Dani Prados dprados@cendrassos.net
 * @version 0.2.5
 *
 * Punt d'netrada de l'aplicació exemple del Framework Emeset.
 * Per provar com funciona es pot executer php -S localhost:8000 a la carpeta public.cd 
 * I amb el navegador visitar la url http://localhost:8000/
 *
 */

use \Emeset\Contracts\Routers\Router;

use App\Controllers\UserController;
use App\Controllers\NavigationController;
use App\Controllers\OrlesControllers;


error_reporting(E_ERROR | E_WARNING | E_PARSE);
include "../vendor/autoload.php";
include "../App/Controllers/perfil.php";
include "../App/Controllers/error.php";
include "../App/Controllers/login.php";
include "../App/Controllers/validarLogin.php";
include "../App/Controllers/tancarSessio.php";


include "../App/Middleware/auth.php";


/* Creem els diferents models */
$contenidor = new \App\Container(__DIR__ . "/../App/config.php");

$app = new \Emeset\Emeset($contenidor);
$app->middleware([\App\Middleware\App::class, "execute"]);

$app->get("", [UserController::class,"index"]);
$app->get("perfil", [UserController::class,"perfil"]);
$app->get("orles", [OrlesControllers::class,"orles"]);
$app->get("contactar", [NavigationController::class,"contactar"]);
<<<<<<< HEAD
$app->get("crear-orles", [OrlesControllers::class,"crearOrles"]);

=======
$app->get("editar-orles", [OrlesControllers::class,"editarOrles"]);
>>>>>>> 0b112acbeba360d59af3671c8a15e06dcca1aa85
$app->post("register", [UserController::class,"register"]);
$app->post("login", [UserController::class,"login"]);
$app->get("logout", [UserController::class,"logout"]);
$app->get("panel-de-control", [NavigationController::class,"panelDeControl"]);
$app->post("updateUser", [UserController::class,"updateUser"]);








$app->route("validar-login", "ctrlValidarLogin");
$app->route("privat", [\App\Controllers\Privat::class, "privat"], ["auth"]);
$app->route("tancar-sessio", "ctrlTancarSessio", ["auth"]);

$app->route("ajax", function ($request, $response) {
    $response->set("result", "ok");
    return $response;
});

$app->route("/hola/{id}", function ($request, $response) {
    $id = $request->getParam("id");
    $response->setBody("Hola {$id}!");
    return $response;
});

$app->route(Router::DEFAULT_ROUTE, "ctrlError");

$app->execute();
