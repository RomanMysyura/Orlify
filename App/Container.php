<?php


namespace App;

use Emeset\Container as EmesetContainer;

class Container extends EmesetContainer {

    public function __construct($config){
        parent::__construct($config);
        
        $this["\App\Controllers\Privat"] = function ($c) {
            // Aqui podem inicialitzar totes les dependències del controlador i passar-les com a paràmetre.
            return new \App\Controllers\Privat($c);
        };
        $this["users"] = function ($c) {
            // Aqui podem inicialitzar totes les dependències del model i passar-les com a paràmetre.
            return new \App\models\Users($c["db"]->getConnection());
        };

        $this["db"] = function ($c) {
            // Aqui podem inicialitzar totes les dependències del model i passar-les com a paràmetre.
            return new \App\models\Db(
                $c["config"]["db"]["user"],
                $c["config"]["db"]["pass"],
                $c["config"]["db"]["db"], 
                $c["config"]["db"]["host"]
            );
        };
    }
}