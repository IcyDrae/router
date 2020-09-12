<?php


namespace Gjoni\Router\Interfaces;


interface DataGenerator
{
    /**
     * @param array $parsed
     * @return mixed
     */
    public function addRoute(array $parsed);

    /**
     * @return array
     */
    public function getData(): array;
}