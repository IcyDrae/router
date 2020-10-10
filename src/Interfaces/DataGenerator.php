<?php


namespace Gjoni\Router\Interfaces;


interface DataGenerator
{
    /**
     * @param array|int $route
     * @return mixed
     */
    public function addRoute($route);

    /**
     * @return array|string
     */
    public function getData();
}