<?php


namespace Route;

use Route\Exception\MethodNotCalledException;
use Route\Exception\ClassNotFoundException;

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

        # Handle the (parsed)route and the callback
        self::handle($parsed, $handler[1], self::getMap());
    }

    private static function handle($parsed, $handler, $map)
    {
        $dispatcher = new Dispatcher;

        try {
            $dispatcher->dispatch($parsed, $handler, $map);
        } catch (ClassNotFoundException $exception) {
            echo $exception;
        } catch (MethodNotCalledException $exception) {
            echo $exception;
        }
    }

    /**
     * @param string $map
     */
    public static function setMap(string $map): void
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
