<?php

namespace Route;

use MongoDB\BSON\ObjectIdInterface;

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
     * Used as part of the workflow inside Dispatcher
     *
     * Makes use of the RouteCollector & DataGenerator and returns the parsed data
     *
     * @param array $route
     * @return array
     */
    public function addRoute(array $route): array
    {
        $parser = new RouteParser;
        $routeParsed = $parser->parse($route[1]);

        $generate = new DataGenerator();

        $generate->addRoute($routeParsed);
        return $generate->getData();
    }

    public function get(array $route) {
        echo $route;
    }
}

if (php_sapi_name() == 'cli') {
    $cl = new RouteCollector();

    $cl->addRoute(["GET", "/user/id/group/id"]);
}