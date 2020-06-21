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
        $parse = new RouteParser($route[1]);
        $generate = new DataGenerator($parse);

        return $generate;
    }

    public function get(array $route) {
        echo $route;
    }
}