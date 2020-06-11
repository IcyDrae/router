<?php

namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

class RouteCollector
{
    private $routeParser;
    private $dataGenerator;

    public function __construct(RouteParser $routeParser, DataGenerator $dataGenerator)
    {
        $this->routeParser = $routeParser;
        $this->dataGenerator = $dataGenerator;
    }

    public function get($route) {
        $parser = new RouteParser($route);
        $generator = new DataGenerator($parser);

        return $generator;
    }
}