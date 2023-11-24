<?php

/**
 * Exemple de MVC per a M07 Desenvolupament d'aplicacions web en entorn de servidor.
 * Router a partir d'un parametre d'entrada.
 * @author: Dani Prados dprados@cendrassos.net
 *
 * Router que escull quin controlador s'ha d'executer
 *
 **/

namespace Emeset\Routers;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Middleware;

/**
 * Router: objecte que enroute a la petició al controlador adequat.
 * @author: Dani Prados dprados@cendrassos.net
 *
 * Permet definir les routes dels controladors
 *
 **/
class RouterHttp implements \Emeset\Contracts\Routers\Router
{
    public $routes = [];
    public $config = [];
    public $router;
    public $container;
    public $caller;

    public function __construct($container, $config)
    {
        // Per ara no fa res
        $this->config = $config;
        $this->container = $container;
        $this->caller = $container["caller"];
    }

    /**
     * Defineix el controlador i el middleware d'una route.
     *
     * @param string $id
     * @param callable $callback
     * @param callable $middleware
     * @return void
     */
    public function route($id, $callback, $middleware = false)
    {
        $this->get($id, $callback, $middleware);
        $this->post($id, $callback, $middleware); //routes[$id] = [$callback, $middleware];
    }

    /**
     * Defineix el controlador i el middleware d'una route.
     *
     * @param string $id
     * @param callable $callback
     * @param callable $middleware
     * @return void
     */
    public function get($id, $callback, $middleware = false)
    {
        $this->routes["GET"][$id] = [$callback, $middleware];
    }

    /**
     * Defineix el controlador i el middleware d'una route.
     *
     * @param string $id
     * @param callable $callback
     * @param callable $middleware
     * @return void
     */
    public function post($id, $callback, $middleware = false)
    {
        $this->routes["POST"][$id] = [$callback, $middleware];
    }

    /**
     * Defineix el controlador i el middleware d'una route.
     *
     * @param string $id
     * @param callable $callback
     * @param callable $middleware
     * @return void
     */
    public function put($id, $callback, $middleware = false)
    {
        $this->routes["PUT"][$id] = [$callback, $middleware];
    }

    /**
     * Defineix el controlador i el middleware d'una route.
     *
     * @param string $id
     * @param callable $callback
     * @param callable $middleware
     * @return void
     */
    public function delete($id, $callback, $middleware = false)
    {
        $this->routes["DELETE"][$id] = [$callback, $middleware];
    }

    /**
     * Defineix el controlador i el middleware d'una route.
     *
     * @param string $id
     * @param callable $callback
     * @param callable $middleware
     * @return void
     */
    public function head($id, $callback, $middleware = false)
    {
        $this->routes["HEAD"][$id] = [$callback, $middleware];
    }

    /**
     * Defineix el controlador i el middleware d'una route.
     *
     * @param string $id
     * @param callable $callback
     * @param callable $middleware
     * @return void
     */
    public function options($id, $callback, $middleware = false)
    {
        $this->routes["OPTIONS"][$id] = [$callback, $middleware];
    }

    /**
     * execute el controlador vinculat a la route definida
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function execute(Request $request,Response $response)
    {
        $dispatcher = \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            foreach ($this->routes as $method => $routes) {
                foreach ($routes as $route => $handler) {
                    if ($route !== 0) {
                        $route = ltrim($route, "/");
                        $r->addRoute($method, "/$route", $handler);
                    }
                }
            }
        });

        // Fetch method and URI from somewhere
        $httpMethod = $request->get(INPUT_SERVER, 'REQUEST_METHOD');
        $uri = $request->get(INPUT_SERVER, 'REQUEST_URI');

        //esborrem les / al final per evitar problemes amb les routes
        $uri = rtrim($uri, '/');
        $uri = str_replace("index.php", "", $uri);
        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        if ($uri == "") {
            $uri = "/";
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                $handler = $this->routes["GET"][0];
                $call = $this->caller->resolve($handler[0]);
                $response = $call($request, $response, $this->container);
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $handler = $this->routes["GET"][0];
                $call = $this->caller->resolve($handler[0]);
                $response = $call($request, $response, $this->container);
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                $request->setParams($vars);

                $action = array();
                $call = $this->caller->resolve($handler[0]);

                if ($handler[1]) {
                    // Si hi ha middleware

                    if (is_array($handler[1])) {
                        array_push($action, ...$handler[1]);
                    } else {
                        array_push($action, $handler[1]);
                    }
                    array_push($action, $call);
                } else {
                    // No hi ha middleware
                    $action[] = $call;
                }
                $response = Middleware::next($request, $response, $this->container, $action);
                break;
        }


        return $response;
    }
}
