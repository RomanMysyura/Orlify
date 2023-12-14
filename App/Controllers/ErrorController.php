<?php

namespace App\Controllers;

class ErrorController 
{
    /**
     * [errorRedirect Funció que redirigeix a la pàgina d'error]
     */
    public function errorRedirect($request, $response, $container)
    {
        $response->SetTemplate("error.php");
        return $response;
    }
   
}

