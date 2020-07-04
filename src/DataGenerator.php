<?php


namespace Route;

require_once(__DIR__ . "./../vendor/autoload.php");

use Route\Interfaces\DataGenerator as DataGeneratorInterface;

class DataGenerator implements DataGeneratorInterface
{

    /*public function __construct($parsed)
    {
        $this->addRoute($parsed);
    }*/

    public function addRoute($parsed)
    {
        $this->getData($parsed);
    }

    public function getData($parser)
    {
        return $parser;
    }
}

/*if (php_sapi_name() === 'cli') {
    $dataGen = new DataGenerator($parsed);

    return $dataGen;
}*/