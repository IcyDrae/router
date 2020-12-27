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
    private static $parsed;
    private static array $methods = [];
    private static array $routes = [];
    private static array $handlers = [];
    private static array $request = [];
    private static int $dispatcherValue;
    private static string $baseRoute = "";
    private static Closure $customHandler;
    private static array $subRoute;

    /**
     * @param $method
     * @param $handler
     * @return string|void
     */
    public static function __callStatic($method, $handler)
    {
        if (!empty(self::$baseRoute)) {
            if (preg_match("/\//", $handler[0])) {
                self::$subRoute["route"] = $handler[0] = self::$baseRoute . $handler[0];
            } else {
                self::$subRoute["route"] = $handler[0];
                self::$subRoute["error"] = true;
            }
        }

        array_push(self::$methods, $method);
        array_push(self::$routes, $handler[0]);
        array_push(self::$handlers, $handler);
    }

    public static function run() {
        self::beforeHandle();
    }

    /**
     * Sets request property
     */
    private static function filterRequest() {
        $requestUri = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $uri = preg_replace("/\/+/", "/", $requestUri);

        if ($_SERVER["REQUEST_METHOD"] == "HEAD") {
            $requestMethod = "GET";
        }

        self::$request = [
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
            self::filterRequest();

            # Quickfix
            # Need to detail the logic more, collect the route and find out where the error actually took place
            if (!empty(self::$subRoute["error"])) {
                header('Content-type:application/json;charset=utf-8');
                http_response_code(400);
                echo json_encode([
                    "error" => "Group definition and all it's subroutes need to be preceded by a slash."
                ]);
                exit();
            }

            # Pass the route to the RouteCollector- will return it parsed as an array
            $collector = new RouteCollector;
            self::$parsed = $collector->addRoute($route, self::$request["uri"]);

            if (!empty(self::$parsed["error"])) {
                header('Content-type:application/json;charset=utf-8');
                http_response_code(400);
                echo self::$parsed;
                exit();
            }

            $handler = self::$handlers[$pos][1];
            $input = [
                "parsed" => self::$parsed,
                "handler" => $handler,
                "map" => self::getMap(),
                "route_method" => self::$methods[$pos],
                "request_method" => strtolower(self::$request["method"])
            ];

            # Call the handler- which then passes the data to the dispatcher
            self::handle($input);

            if (self::$dispatcherValue == 1) {
                break;
            }

            # If we're at the last position and still haven't found a route, it means this route is not defined in our application
            if ($pos == array_key_last(self::$routes) && self::$dispatcherValue == 0) {

                # If the custom handler is set, trigger it and exit
                if (!empty(self::$customHandler)) {
                    call_user_func(self::$customHandler);
                    exit();
                }

                header('Content-type:application/json;charset=utf-8');
                http_response_code(404);
                $e = new InvalidRouteException();
                echo json_encode([
                    "error" => $e->getMessage()
                ]);
                exit();
            }

            ++$pos;
        }
    }

    /**
     * The route subrouting method, sets the global property $baseRoute, calls the callable and resets the property again
     *
     * @param $group
     * @param Closure $handler
     */
    public static function group($group, Closure $handler) {
        if (!is_string($group)) {
            header('Content-type:application/json;charset=utf-8');
            echo json_encode([
                "error" => "Group definition needs to be a string, also preceded by a slash."
            ]);
            exit();
        }
        self::$baseRoute .= $group;

        call_user_func($handler);

        self::$baseRoute = "";
    }

    /**
     * Custom 404 handler, used to override the default 404 handling defined in beforeHandle
     *
     * @param Closure $customHandler
     */
    public static function setNotFound(Closure $customHandler)
    {
        self::$customHandler = $customHandler;
    }

    /**
     * Handles the parsed data by initializing the dispatcher
     *
     * @param $input
     * @return ClassNotFoundException|MethodNotCalledException|void
     */
    private static function handle($input)
    {
        $dispatcher = new Dispatcher;

        try {
            self::$dispatcherValue = $dispatcher->dispatch($input);
        } catch (ClassNotFoundException $exception) {
            header('Content-type:application/json;charset=utf-8');
            echo json_encode([
                "error" => $exception->getMessage()
            ]);
            exit();
        } catch (MethodNotCalledException $exception) {
            header('Content-type:application/json;charset=utf-8');
            echo json_encode([
                "error" => $exception->getMessage()
            ]);
            exit();
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
