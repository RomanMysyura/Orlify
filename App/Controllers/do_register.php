<?php

session_start();

function ctrlDoRegister($request, $response, $container){

    $taskModel = $container->users();
    $name = $request->get(INPUT_POST, "name");
    $lastname = $request->get(INPUT_POST, "lastname");
    $dni = $request->get(INPUT_POST, "dni");
    $birth_date = $request->get(INPUT_POST, "birth_date");
    $role = $request->get(INPUT_POST, "role");
    

    $taskModel->addUser($name,$lastname,$dni,$birth_date,$role);


    $response->redirect("location: index.php?r=register");
    return $response;
}