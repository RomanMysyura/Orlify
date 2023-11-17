<?php

function ctrlDoRegister($request, $response, $container){
    // Verificar si $container["users"] está definido
    if (isset($container["users"])) {
        $taskModel = $container["users"];

        $name = $request->get(INPUT_POST, "name");
        $lastname = $request->get(INPUT_POST, "lastname");
        $dni = $request->get(INPUT_POST, "dni");
        $birth_date = $request->get(INPUT_POST, "birth_date");
        $role = $request->get(INPUT_POST, "role");

        // Verificar si $taskModel es un objeto antes de llamar a addUser()
        if ($taskModel instanceof \App\models\UsersPDO) {
            $taskModel->addUser($name, $lastname, $dni, $birth_date, $role);
            $response->redirect("location: /register");
            return $response;
        } else {
            // Manejar el caso en que $taskModel no es una instancia de UsersPDO
            echo "Error: La instancia de Users no es válida.";
        }
    } else {
        // Manejar el caso en que $container["users"] no está definido
        echo "Error: No se encontró la instancia de Users en el contenedor.";
    }
}
