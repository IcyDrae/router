<?php


namespace Gjoni\Router;

use Gjoni\Router\Interfaces\RouteParser as RouteParserInterface;

class RouteParser implements RouteParserInterface
{
    /**
     * Parses a given string into an array containing either the route(s) split by "/" or the arguments with their name as the key
     *
     * Accepted format is: "/users", "/user/{id}", "/user/{id}/groups" "/user/{id}/group/{id}"
     *
     * @param string $route
     * @param string $uri
     * @return array
     */
    public function parse(string $route, string $uri): array
    {
        # Base route parsing pattern
        $allowedCharacters = "[a-zA-Z0-9\_]+";

        # Swap the route annotation with it's corresponding pattern so it can be verified against in the Router
        $pattern = preg_replace("/{($allowedCharacters)}/",
                            "(?<$1>$allowedCharacters)", $route);

        $regex = "@^$pattern$@D";

        preg_match($regex, $uri, $matches);

        # Handle static routes
        if (!empty($matches) && !isset($matches[1])) {
            $matches = preg_split('/[\/]/', $matches[0], NULL, PREG_SPLIT_NO_EMPTY);
        }

        return $matches;
    }
}
