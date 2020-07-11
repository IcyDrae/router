<?php


namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

use Route\Interfaces\RouteParser as RouteParserInterface;

class RouteParser implements RouteParserInterface
{
    private array $parsedRoute;

    /**
     * RouteParser constructor.
     */
    public function __construct()
    {
    }

    /**
     * Parses a given string into an array containing a series of arrays per route group
     *
     * Accepted format is: "/users", "/user/id/", "/user/id/groups" "/user/id/group/id/"
     *
     * @param string $route
     * @return array
     */
    public function parse(string $route): array
    {
        $parsedRoute = [];
        $matches = [];
        $pattern = "/\/[a-z]*\/*[a-z0-9]+/";

        preg_match_all($pattern, $route, $matches);

        foreach ($matches[0] as $value => $match) {
            /**
             * /users/id/category/id -> [
             *              ["users", "id"],
             *              ["category", "id"],
             *            ]
             */
            $split = preg_split('/\//', $match, NULL, PREG_SPLIT_NO_EMPTY);

            $parsedRoute[] = [
              "base" => $split[0],
              "argument" => (!empty($split[1]) ? $split[1] : "")
            ];
        }
        $this->parsedRoute = $parsedRoute;

        return $this->parsedRoute;
    }
}
