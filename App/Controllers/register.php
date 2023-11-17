<?php

use \Emeset\Contracts\Http\Request;
use \Emeset\Contracts\Http\Response;
use \Emeset\Contracts\Container;

function ctrlRegister(Request $request, Response $response, Container $container): Response
{
    // Verificar si la solicitud es de tipo POST

    // Resto de tu código...

    $response->SetTemplate("register.php");

    return $response;
}
