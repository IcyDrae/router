<?php


namespace Route;

use Route\Exception\MethodNotAllowedException;
use Route\Exception\InvalidRouteException;
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
    private static string $map = "App\Controllers"; # Default mapping
    private static array $parsed;
    private static string $route;
    private static string $method;
    private static $handler;

    /**
     * @param $method
     * @param $handler
     * @return string|void
     */
    public static function __callStatic($method, $handler)
    {
        # Take the route given and give it to the RouteCollector- will return it parsed as an array
        $collector = new RouteCollector;
        self::$parsed = $collector->addRoute($handler[0]);
        self::$handler = $handler[1];
        self::$route = $handler[0];

        self::filterRequest($method, self::$route);
    }

    /**
     * @param $method
     * @param $route
     * @return MethodNotAllowedException|InvalidRouteException|void
     */
    private static function filterRequest($method, $route) {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $singleSlashesUri = preg_replace("/\/+/", "/", $requestUri);

        $uri = trim($singleSlashesUri, "/");
        $route = trim($route, "/");

        $method = strtoupper($method);

        #TODO handle HEAD requests

        #var_dump($route);
        if ($uri == $route) {
            if ($requestMethod == $method) {
                # Handle the (parsed)route and the callback
                self::handle(self::$parsed, self::$handler, self::getMap());
            } else {
                return new MethodNotAllowedException;
            }
        } else {
            return new InvalidRouteException;
        }
    }

    /**
     * @param $parsed
     * @param $handler
     * @param $map
     * @return ClassNotFoundException|MethodNotCalledException|void
     */
    private static function handle($parsed, $handler, $map)
    {
        $dispatcher = new Dispatcher;

        try {
            $dispatcher->dispatch($parsed, $handler, $map);
        } catch (ClassNotFoundException $exception) {
            return $exception;
        } catch (MethodNotCalledException $exception) {
            return $exception;
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
