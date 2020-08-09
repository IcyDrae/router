<?php


namespace Route;

/*
 * Change architecture: Router should be the entry point(should take the route)
                            -> gives it to the route collector and give the parsed back
                            -> dispatcher dispatches that request into the project

    Note: Route should have the dynamic request methods

    Note 2: Dispatcher can take the generated data from the DataGenerator as described from the document
*/

/**
 * @method static Router get(string $route, callable|string $handler)
 * @method static Router post(string $route, callable|string $handler)
 * @method static Router put(string $route, callable|string $handler)
 * @method static Router delete(string $route, callable|string $handler)
 */

class Router
{
    private static string $map;

    public static function __callstatic($method, $handler)
    {
        # Take the route given and give it to the RouteCollector- will return it parsed as an array
        $collector = new RouteCollector;
        $parsed = $collector->addRoute($handler[0]);

        # Define namespace for the dispatcher
        self::setMap("\Test\Controllers");

        # Handle the (parsed)route and the callback
        self::handle($parsed, $handler[1], self::getMap());
    }

    private static function handle($parsed, $handler, $map)
    {
        $dispatcher = new Dispatcher;

        $dispatcher->dispatch($parsed, $handler, $map);
    }

    /**
     * @param string $map
     */
    private static function setMap(string $map): void
    {
        self::$map = $map;
    }

    /**
     * @return mixed
     */
    private static function getMap()
    {
        return self::$map;
    }

}
