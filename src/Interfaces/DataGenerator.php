<?php


namespace Gjoni\Router\Interfaces;


interface DataGenerator
{
    /**
     * @param array $route
     * @return mixed
     */
    public function addRoute(array $route);

    /**
     * @return array|string
     */
    public function getData();
}