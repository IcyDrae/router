<?php


namespace Gjoni\Router;

use Closure;
use Gjoni\Router\Exception\InvalidRouteException;
use Gjoni\Router\Exception\MethodNotCalledException;
use Gjoni\Router\Exception\ClassNotFoundException;

/**
 * @method static Router get(string $route, Closure|string $handler)
 * @method static Router post(string $route, Closure|string $handler)
 * @method static Router put(string $route, Closure|string $handler)
 * @method static Router patch(string $route, Closure|string $handler)
 * @method static Router delete(string $route, Closure|string $handler)
 */

class Router
{
    private static string $map = "App\Controllers"; # Default mapping
    private static array $parsed;
    private static array $methods = [];
    private static array $routes = [];
    private static array $handlers = [];
    private static int $dispatcherValue;

    /**
     * @param $method
     * @param $handler
     * @return string|void
     */
    public static function __callStatic($method, $handler)
    {
        array_push(self::$methods, $method);
        array_push(self::$routes, $handler[0]);
        array_push(self::$handlers, $handler);
    }

    public static function run() {
        self::beforeHandle();
    }

    /**
     * @return array $request
     */
    private static function filterRequest() {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestMethod = strtolower($_SERVER["REQUEST_METHOD"]);
        $uri = preg_replace("/\/+/", "/", $requestUri);

        return $request = [
            "method" => $requestMethod,
            "uri" => $uri
        ];
    }

    /**
     * @return bool|void|InvalidRouteException[]
     */
    private static function beforeHandle()
    {
        $pos = 0;

        foreach (self::$routes as $route) {
            # Pass the route to the RouteCollector- will return it parsed as an array
            $collector = new RouteCollector;
            self::$parsed = $collector->addRoute($route, self::filterRequest()["uri"]);

            $handler = self::$handlers[$pos][1];
            $input = [
                "parsed" => self::$parsed,
                "handler" => $handler,
                "map" => self::getMap(),
                "route_method" => self::$methods[$pos],
                "request_method" => self::filterRequest()["method"]
            ];

            # Call the handler- which then passes the data to the dispatcher
            self::handle($input);

            if (self::$dispatcherValue == 1) {
                break;
            }

            # If we're at the last position and still haven't found a route, it means this route is not defined in our application
            if ($pos == array_key_last(self::$routes) && self::$dispatcherValue == 0) {
                return [
                    "exception" => new InvalidRouteException()
                ];
            }

            ++$pos;
        }
    }

    /**
     * @param $input
     * @return ClassNotFoundException[]|MethodNotCalledException[]|void
     */
    private static function handle($input)
    {
        $dispatcher = new Dispatcher;

        try {
            self::$dispatcherValue = $dispatcher->dispatch($input);
        } catch (ClassNotFoundException $exception) {
            return [$exception];
        } catch (MethodNotCalledException $exception) {
            return [$exception];
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
