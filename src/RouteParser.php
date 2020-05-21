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
     */
    public function parse(String $route)
    {
        $pattern = "/\//";
        # note: regex101: ^[a-z]+\/{[a-z]+}$
        $array = preg_split($pattern, $route);

        var_dump($array);

        // TODO: optional parameters such as: /this/route/{id}
    }
}


if (php_sapi_name() === 'cli') {
    $parser = new RouteParser("this/{route}");

    return $parser;
}