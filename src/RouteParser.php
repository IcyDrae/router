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
        $parsedRoute = [];
        $matches = [];
        $pattern = "/\/[a-z]*\/*[a-z0-9]+/";

        preg_match_all($pattern, $route, $matches);

        foreach ($matches[0] as $value => $match) {
            /**
             * /users/1 -> [
             *              ["users", "1"],
             *            ]
             */
            $split = preg_split('/\//', $match, NULL, PREG_SPLIT_NO_EMPTY);

            $parsedRoute[] = [
              "base" => $split[0],
              "argument" => (!empty($split[1]) ? $split[1] : "")
            ];
        }

        return $parsedRoute;
    }
}


if (php_sapi_name() === 'cli') {
    $parser = new RouteParser("/users/1/playlist/2/songs");

    return $parser;
}