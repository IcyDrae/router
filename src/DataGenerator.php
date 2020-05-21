<?php


namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

use Route\Interfaces\DataGenerator as DataGeneratorInterface;

class DataGenerator implements DataGeneratorInterface
{
    private $string;

    public function __construct($string)
    {
        $this->string = $string;

        echo $string;
    }

    public function getData()
    {
        // TODO: Implement getData() method.
    }

    public function addRoute()
    {
        // TODO: Implement addRoute() method.
    }
}