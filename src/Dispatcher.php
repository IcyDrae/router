<?php

namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

use Route\Exception\InvalidRouteException;
use Route\Interfaces\Dispatcher as DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    private $collector;

    /**
     * Dispatcher constructor.
     * @param callable $routeCollector
     */
    public function __construct(callable $routeCollector)
    {
        $this->collector = $routeCollector;

        if ($routeCollector instanceof RouteCollector) {
            echo ($routeCollector);
        }
    }

    /**
     * @inheritDoc
     */
    public function getRoute($string)
    {
        // TODO: Implement getRoute() method.
    }
}

if (php_sapi_name() == 'cli') {
    $dispatch = new Dispatcher(function(RouteCollector $routeCollector) {
        $routeCollector->get("route/slash");
    });

    echo ($dispatch);
}