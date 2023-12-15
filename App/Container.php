<?php


namespace App;

use Emeset\Container as EmesetContainer;

class Container extends EmesetContainer {

    public function __construct($config){
        parent::__construct($config);
        
        $this["\App\Models\Db"] = function ($c) {
            // Aqui podem inicialitzar totes les dependències del controlador i passar-les com a paràmetre.
            return new \App\Models\Db(
                $c["config"]["database"]["username"],
                $c["config"]["database"]["password"],
                $c["config"]["database"]["database"],
                $c["config"]["database"]["server"]
            );
        };

               
        $this["\App\Models\Orles"] = function ($c) {
            // Aqui podem inicialitzar totes les dependències del controlador i passar-les com a paràmetre.
            return new \App\Models\Orles(
                $c["\App\Models\Db"]->getConnection()
            );
        
        };
        $this["\App\Models\usersPDO"] = function ($c) {
            // Aqui podem inicialitzar totes les dependències del controlador i passar-les com a paràmetre.
            return new \App\Models\usersPDO(
                $c["\App\Models\Db"]->getConnection()
            );
        
        };

        
        
    }

    
}