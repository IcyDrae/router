<?php


namespace Gjoni\Router\Interfaces;


interface RouteParser
{
    /**
     * @param string $route
     * @param string $uri
     * @return array
     */
    public function parse(string $route, string $uri): array;
}