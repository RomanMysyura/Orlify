<?php

namespace App\Middleware;
use \Emeset\Contracts\Http\Request;
use \Emeset\Contracts\Http\Response;
use \Emeset\Contracts\Container;

class App {
    function permissions(Request $request, Response $response, Container $container, $next): Response
    {
        $role = $request->get("SESSION", "role");
    
        if (!isset($role) || $role !== "Equip Directiu") {

            header("Location: /errorweb");
            exit();
        }
        $response = \Emeset\Middleware::next($request, $response, $container, $next);
        return $response;
    }

    function permissionsProfessor(Request $request, Response $response, Container $container, $next): Response
    {
        $role = $request->get("SESSION", "role");
        if (!isset($role) || ($role !== "Equip Directiu" && $role !== "Professor")) {
            
            header("Location: /errorweb");
            exit();
        }
        $response = \Emeset\Middleware::next($request, $response, $container, $next);
        return $response;
    }



    public static function execute(Request $request, Response $response, Container $container, $next) :Response
    {
        // Code before FrontConroller

        $response->set("app_config", $container["config"]);
     
        $response = \Emeset\Middleware::next($request, $response, $container, $next);
        return $response;
    }
}