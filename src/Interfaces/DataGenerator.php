<?php


namespace Route\Interfaces;


interface DataGenerator
{
    public function addRoute(array $parsed);
    public function getData(): array;
}