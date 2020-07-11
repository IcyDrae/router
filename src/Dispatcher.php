<?php

namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

use Route\Interfaces\Dispatcher as DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    public function __construct(callable $collector)
    {
        return $collector;
    }

    /**
     * @inheritDoc
     */
    public function dispatch()
    {
        // TODO: Implement getRoute() method.
        echo "dispatching";
    }
}

/*if (php_sapi_name() == 'cli') {
    $dispatcher = new Dispatcher(function (RouteCollector $route) {
        $route->addRoute(["GET", "/users/3452"]);
    });

    $dispatcher->dispatch(); # should dispatch the contents of L#28(addRoute array). How?
}*/