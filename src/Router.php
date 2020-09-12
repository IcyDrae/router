<?php


namespace Gjoni\Router;

use Gjoni\Router\Exception\MethodNotAllowedException;
use Gjoni\Router\Exception\InvalidRouteException;
use Gjoni\Router\Exception\MethodNotCalledException;
use Gjoni\Router\Exception\ClassNotFoundException;

/**
 * @method static Router get(string $route, callable|string $handler)
 * @method static Router post(string $route, callable|string $handler)
 * @method static Router put(string $route, callable|string $handler)
 * @method static Router patch(string $route, callable|string $handler)
 * @method static Router delete(string $route, callable|string $handler)
 */

class Router
{
    private static string $map = "App\Controllers"; # Default mapping
    private static array $parsed;
    private static string $route;
    private static array $methods = [];
    private static array $routes = [];
    private static array $handlers = [];

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

    /**
     * TODO dynamic route parsing URL
     * TODO static/dynamic route generation in the DataGenerator
     */

    public static function run() {
        self::filterRequest();
    }

    /**
     * @return MethodNotAllowedException|InvalidRouteException|bool|void
     */
    private static function filterRequest() {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $uri = preg_replace("/\/+/", "/", $requestUri);

        $routeKeys = array_keys(self::$routes, $uri);
        $routeExists = false;

        foreach ($routeKeys as $key) {
            $method = strtoupper(self::$methods[$key]);
            # A route corresponding to the request exists at this point
            $routeExists = true;
            $route = self::$routes[$key];

            # Handle HEAD requests and match them to available GET routes
            if ($requestMethod == "HEAD" && $method == "GET") {
                $method = "HEAD";
            }

            if ($method == $requestMethod) {
                # Pass the route to the RouteCollector- will return it parsed as an array
                $collector = new RouteCollector;
                self::$parsed = $collector->addRoute($route);
                $handler = self::$handlers[$key][1];

                # Call the handler- which then passes the data to the dispatcher
                self::handle(self::$parsed, $handler, self::getMap());
            } else {
                http_response_code(405);

                return new MethodNotAllowedException;
            }
        }

        if (!$routeExists) {
            http_response_code(404);

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
