<?php

namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

class RouteCollector
{
    // TODO: search how to do dynamic methods to have: get, post, put etc available

    /*public function __construct($route)
    {
        $routeParser = new RouteParser($route);
        $dataGenerator = new DataGenerator($routeParser);

        return $dataGenerator->getData(); # not really
    }*/

    /**
     * @param array $route
     * @return DataGenerator
     */
    public function addRoute(array $route)
    {
        $routeParsed = new RouteParser($route[1]);
        $generate = new DataGenerator();

        $generate->addRoute($routeParsed);

        return $generate;
    }

    public function get(array $route) {
        echo $route;
    }
}

if (php_sapi_name() == 'cli') {
    $cl = new RouteCollector();

    $cl->addRoute(["GET", "/user/id/group/id"]);
}