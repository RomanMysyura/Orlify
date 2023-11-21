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
  
    public function panelDeControl($request, $response, $container)
    {
        $response->SetTemplate("paneldecontrol.php");

        return $response;
    }
   
}
