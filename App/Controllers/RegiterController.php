<?php

namespace App\Controllers;

class RegisterController 
{
    public function register($request, $response, $container)
    {

      $error = $request->get("SESSION", "error");
      $response->set("error", $error);
      $response->redirect("Location: /");

      return $response;
    }
}