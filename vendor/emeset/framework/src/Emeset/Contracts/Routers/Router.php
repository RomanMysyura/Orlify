<?php

/**
 * Exemple de MVC per a M07 Desenvolupament d'aplicacions web en entorn de servidor.
 * Interface d'un Router.
 * @author: Dani Prados dprados@cendrassos.net
 *
 * Router que escull quin controlador s'ha d'executer
 *
 **/

namespace Emeset\Contracts\Routers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;

/**
 * Router: interficie que ha d'implementar un router.
 * @author: Dani Prados dprados@cendrassos.net
 *
 **/

interface Router
{

    public const DEFAULT_ROUTE = 0;

    public function route($id, $callback, $middleware = false);
    public function execute(Request $request, Response $response);
    public function get($id, $callback, $middleware = false);
    public function post($id, $callback, $middleware = false);
    public function put($id, $callback, $middleware = false);
    public function delete($id, $callback, $middleware = false);
    public function head($id, $callback, $middleware = false);
}
