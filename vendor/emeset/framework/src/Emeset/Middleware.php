<?php

namespace Emeset;
use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use Emeset\Contracts\Middleware as MiddlewareInterface;

class Middleware implements MiddlewareInterface
{
    /**
     * Call the next middleware or page controller passed through the
     *
     * @param $request
     * @param $response
     * @param $container
     * @param $next
     * @return mixed
     */
    public static function next(Request $request, Response $response, Container $container, $next)
    {
        if (is_array($next)) {
            //            A middleware has been defined
            if (count($next) > 1) {

                //                A single callable array or 2 string callables
                if (count($next) === 3 && is_string($next[0]) && is_string($next[1])) {
                    $call = [$next[0], $next[1]];

                    //                    Check if it's callable array
                    if (is_callable($call)) {
                        $response = $call($request, $response, $container, [$next[2]]);

                        //                    If it's only 2 string callables
                    } else {
                        $call = array_shift($next);
                        $response = $call($request, $response, $container, $next);
                    }
                    //                    An array of either callables or string callables
                } else {
                    $call = array_shift($next);
                    $response = $call($request, $response, $container, $next);
                }
            } else {
                $response = call_user_func($next[0], $request, $response, $container);
            }
        } else {
            $response = call_user_func($next, $request, $response, $container);
        }

        return $response;
    }
}
