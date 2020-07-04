<?php


namespace Route\Interfaces;


interface DataGenerator
{
    public function addRoute($parsed);
    public function getData($parser);
}