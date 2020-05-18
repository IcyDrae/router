<?php

namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

class RouteCollector
{
    private $routeParser;
    private $dataGenerator;
    private $routeArray = [];

    public function __construct(RouteParser $routeParser, DataGenerator $dataGenerator)
    {
        $this->routeParser = $routeParser;
        $this->dataGenerator = $dataGenerator;

        $this->routeArray = [
            "Parser" => $this->routeParser,
            "Generator" => $this->dataGenerator
        ];

        foreach ($this->routeArray as $key => $class) {
            print_r($key);
        }
    }

    public function get($route): string {
        return var_dump($route);
    }
}

/*if (php_sapi_name() == 'cli') {
    $obj = new RouteCollector(new RouteParser("hey"), new DataGenerator("route"));
    return $obj;
}*/