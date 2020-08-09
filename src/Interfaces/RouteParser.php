<?php


namespace Route\Interfaces;


interface RouteParser
{
    /**
     * @param string $route
     * @return array
     */
    public function parse(string $route): array;

}