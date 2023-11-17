<?php

session_start();

function ctrlRegister($request, $response, $container){

    $response->setTemplate("register.php");

    return $response;
}