<?php

namespace App\Middleware;
use \Emeset\Contracts\Http\Request;
use \Emeset\Contracts\Http\Response;
use \Emeset\Contracts\Container;

class App {

    public static function execute(Request $request, Response $response, Container $container, $next) :Response
    {
        // Code before FrontConroller

        $response->set("app_config", $container["config"]);
        $usuari = $request->get("SESSION", "usuari");
        $logat = $request->get("SESSION", "logat");
    
        if (!isset($logat)) {
            $usuari = "";
            $logat = false;
            $response->set("usuari",['token'=>'']);
            
        }
    else{
        $response->set("usuari", $usuari);
        
    }
        print_r($usuari);
        $response->set("logat", $logat);
        //echo "App Middleware";
        $response = \Emeset\Middleware::next($request, $response, $container, $next);
        // Code after FrontConroller

        return $response;
    }
}