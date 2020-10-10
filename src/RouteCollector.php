<?php

namespace Gjoni\Router;


class RouteCollector
{
    /**
     * Used as part of the workflow in the Router
     *
     * Makes use of the RouteParser & DataGenerator and returns the parsed data
     *
     * @param string $route
     * @param string $uri
     * @return array
     */
    public function addRoute(string $route, string $uri)
    {
        $parser = new RouteParser;
        $routeParsed = $parser->parse($route, $uri);

        $generator = new DataGenerator;

        $generator->addRoute($routeParsed);
        return $generator->getData();
    }
}
