<?php


namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

use Route\Interfaces\RouteParser as RouteParserInterface;

class RouteParser implements RouteParserInterface
{
    private $route;

    public function __construct($route)
    {
        $this->route = $route;

        $this->parse($route);
    }

    /**
     * @param String $route
     * @return array
     */
    public function parse(String $route): array
    {
        $pattern = "/^\/?([a-z]+)?\/([a-zA-Z0-9]+)?$/";
        $matches = [];

        $operation = preg_match_all($pattern, $route, $matches);

        $fullMatch = [
            "full_path" =>  json_encode($matches[0], JSON_UNESCAPED_SLASHES)
        ];

        $parsedRoute = [
            "base" => json_encode($matches[1]),
            "argument" => json_encode($matches[2])
        ];

        return $parsedRoute;

        // TODO: optional parameters such as: /this/{id}
    }
}


if (php_sapi_name() === 'cli') {
    $parser = new RouteParser("/user/12");

    return $parser;
}