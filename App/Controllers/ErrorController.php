<?php

namespace App\Controllers;

class ErrorController 
{
    public function errorRedirect($request, $response, $container)
    {
        $response->SetTemplate("error.php");
        return $response;
    }
   
}

