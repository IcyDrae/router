<?php


namespace Gjoni\Router\Interfaces;


interface RouteParserInterface
{
    public const NOT_ALLOWED_CHARS = 0;

    /**
     * @param string $route
     * @param string $uri
     * @return array|int
     */
    public function parse(string $route, string $uri);
}