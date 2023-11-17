<?php

use \Emeset\Contracts\Http\Request;
use \Emeset\Contracts\Http\Response;
use \Emeset\Contracts\Container;


function ctrlTest(Request $request, Response $response, Container $container) :Response
{
    
    $response->SetTemplate("test.php");

    return $response;
}
