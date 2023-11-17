<?php

namespace Emeset;
use Emeset\Contracts\Env as EnvInterface;

class Env implements EnvInterface
{

    /**
     * Obté una variable d'entorn
     * @param string $key identificador de la variable
     * @param mixed $default valor per defecte si no existeix la variable
     * @return mixed
     */
    static public function get(string $key, $default = null)
    {
        $value = $default;
        if (isset($_ENV[$key])) {
            $value = $_ENV[$key];
        }
        return $value;
    }
}
