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



include "../App/Middleware/auth.php";


/* Creem els diferents models */
$contenidor = new \App\Container(__DIR__ . "/../App/config.php");

$app = new \Emeset\Emeset($contenidor);
$app->middleware([\App\Middleware\App::class, "execute"]);

$app->get("", [UserController::class,"index"]);
$app->get("perfil", [UserController::class,"perfil"]);
$app->get("carnet", [UserController::class,"carnetUser"]);
$app->get("photo", [UserController::class,"photoUser"]);
$app->get("orles", [OrlesControllers::class,"orles"]);
$app->get("contactar", [UserController::class,"contactar"]);
$app->post("enviarcontactar", [UserController::class,"enviarcontactar"]);
$app->get("alumnes", [UserController::class,"alumnes"]);
$app->get("editar-orles", [OrlesControllers::class,"editarOrles"]);
$app->post("register", [UserController::class,"register"]);
$app->post("randomuser", [UserController::class,"randomuser"]);
$app->post("login", [UserController::class,"login"]);
$app->post("uploadUser", [UserController::class,"uploadUser"]);
$app->get("logout", [UserController::class,"logout"]);
$app->get("panel-de-control", [NavigationController::class,"panelDeControl"]);
$app->post("updateUser", [UserController::class,"updateUser"]);
$app->post("uploadUserAdmin", [UserController::class,"uploadUserAdmin"]);
$app->post("uploadPhoto", [UserController::class,"uploadPhoto"]);
$app->post("uploadPhotoFromFile", [UserController::class,"uploadPhotoFromFile"]);
$app->post("add_users_to_orla", [OrlesControllers::class,"add_users_to_orla"]);
$app->post("PanelUploadUser", [UserController::class,"PanelUploadUser"]);
$app->get("Idpanel", [UserController::class,"Idpanel"]);
$app->get("deleteUser", [UserController::class,"deleteUser"]);
$app->get("DeleteGrup", [UserController::class,"DeleteGrup"]);
$app->post("crearGrup", [UserController::class,"crearGrup"]);
$app->get("/carnet/{token}", [UserController::class, "carnetUser"]);
$app->get("deleteerror", [UserController::class,"deleteerror"]);
$app->post("uploaderror", [UserController::class,"uploaderror"]);
$app->get("create-new-orla", [OrlesControllers::class,"createNewOrla"]);
$app->post("UploadOrla", [OrlesControllers::class,"UploadOrla"]);
$app->get("eliminarOrlaPanel", [OrlesControllers::class,"eliminarOrlaPanel"]);
$app->get("eliminarPhoto", [OrlesControllers::class,"eliminarPhoto"]);
$app->get("recuperarpass", [NavigationController::class,"recuperarpass"]);
$app->post("publish-orla", [OrlesControllers::class,"publish_orla"]);
$app->get("descarregar-orla/{id}/{formato_impresion}", [OrlesControllers::class, "descarregarOrla"]);
$app->get("eliminar-orla", [OrlesControllers::class,"eliminarOrla"]);
$app->post("updateNameOrla", [OrlesControllers::class,"updateNameOrla"]);
$app->post("sendRecoveryEmail", [UserController::class,"sendRecoveryEmail"]);
$app->post("erroremail", [UserController::class,"sendRecoveryEmail"]);
$app->get("newpass", [UserController::class,"newpass"]);
$app->post("newpass", [UserController::class,"newpass"]);







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