<?php


namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

use Route\Interfaces\DataGenerator as DataGeneratorInterface;

class DataGenerator implements DataGeneratorInterface
{

    public function __construct()
    {
        $this->addRoute();
    }

    public function addRoute()
    {
        $this->getData();
    }

    public function getData()
    {
        $parser = new RouteParser("/user/111");

        return $parser;
    }
}

if (php_sapi_name() === 'cli') {
    $parser = new DataGenerator;

    return $parser;
}