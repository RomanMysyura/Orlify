<?php

use \Emeset\Contracts\Http\Request;
use \Emeset\Contracts\Http\Response;
use \Emeset\Contracts\Container;


function ctrlPerfil(Request $request, Response $response, Container $container) :Response
{
    
    $response->SetTemplate("perfil.php");

    return $response;
}
