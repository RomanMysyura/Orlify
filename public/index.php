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
use App\Controllers\ErrorController;


error_reporting(E_ERROR | E_WARNING | E_PARSE);
include "../vendor/autoload.php";


/* Creem els diferents models */
$contenidor = new \App\Container(__DIR__ . "/../App/config.php");

$app = new \Emeset\Emeset($contenidor);
$app->middleware([\App\Middleware\App::class, "execute"]);

$app->get("", [UserController::class,"index"]);
$app->get("perfil", [UserController::class,"perfil"]);
$app->get("carnet", [UserController::class,"carnetUser"]);
$app->get("photo", [UserController::class,"photoUser"]);
$app->get("orles", [OrlesControllers::class,"orles"]);
$app->get("meves-orles", [OrlesControllers::class,"mevesOrles"]);
$app->get("contactar", [UserController::class,"contactar"]);
$app->post("enviarcontactar", [UserController::class,"enviarcontactar"]);
$app->get("alumnes", [UserController::class,"alumnes"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->get("editar-orles", [OrlesControllers::class,"editarOrles"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->post("register", [UserController::class,"register"]);
$app->post("randomuser", [UserController::class,"randomuser"], [[\App\Middleware\App::class,"permissions"]]);
$app->post("login", [UserController::class,"login"]);
$app->post("uploadUser", [UserController::class,"uploadUser"]);
$app->get("logout", [UserController::class,"logout"]);
$app->get("panel-de-control", [NavigationController::class,"panelDeControl"], [[\App\Middleware\App::class,"permissions"]]);
$app->get("recuperarpass", [NavigationController::class,"recuperarpass"]);
$app->post("uploadUserAdmin", [UserController::class,"uploadUserAdmin"], [[\App\Middleware\App::class,"permissions"]]);
$app->post("uploadPhoto", [UserController::class,"uploadPhoto"]);
$app->post("uploadPhotoFromFile", [UserController::class,"uploadPhotoFromFile"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->post("uploadPhotoFromFileEdit", [UserController::class,"uploadPhotoFromFileEdit"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->post("add_users_to_orla", [OrlesControllers::class,"add_users_to_orla"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->get("Idpanel", [UserController::class,"Idpanel"]);
$app->get("deleteUser", [UserController::class,"deleteUser"], [[\App\Middleware\App::class,"permissions"]]);
$app->get("DeleteGrup", [UserController::class,"DeleteGrup"], [[\App\Middleware\App::class,"permissions"]]);
$app->post("crearGrup", [UserController::class,"crearGrup"], [[\App\Middleware\App::class,"permissions"]]);
$app->get("/carnet/{token}", [UserController::class, "carnetUserUrl"]);
$app->get("deleteerror", [UserController::class,"deleteerror"], [[\App\Middleware\App::class,"permissions"]]);
$app->post("uploaderror", [UserController::class,"uploaderror"], [[\App\Middleware\App::class,"permissions"]]);
$app->get("create-new-orla", [OrlesControllers::class,"createNewOrla"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->post("UploadOrla", [OrlesControllers::class,"UploadOrla"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->get("eliminarOrlaPanel", [OrlesControllers::class,"eliminarOrlaPanel"], [[\App\Middleware\App::class,"permissions"]]);
$app->get("eliminarPhoto", [OrlesControllers::class,"eliminarPhoto"], [[\App\Middleware\App::class,"permissions"]]);
$app->post("publish-orla", [OrlesControllers::class,"publish_orla"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->get("descarregar-orla/{id}/{formato_impresion}", [OrlesControllers::class, "descarregarOrla"]);
$app->get("eliminar-orla", [OrlesControllers::class,"eliminarOrla"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->post("updateNameOrla", [OrlesControllers::class,"updateNameOrla"], [[\App\Middleware\App::class,"permissionsProfessor"]]);
$app->post("sendRecoveryEmail", [UserController::class,"sendRecoveryEmail"]);
$app->get("newpass", [UserController::class,"newpass"]);
$app->post("newpass", [UserController::class,"newpass"]);
$app->get("errorweb", [ErrorController::class,"errorRedirect"]);


$app->execute();