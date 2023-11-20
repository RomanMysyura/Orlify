<?php

namespace App\Controllers;

use App\Models\Db;
use App\Models\UsersPDO;

class NavigationController 
{
   
    public function contactar($request, $response, $container)
    {
        $response->SetTemplate("contactar.php");

        return $response;
    }
    public function crearOrles($request, $response, $container)
    {
        $response->SetTemplate("crearOrles.php");

        return $response;
    }
}
