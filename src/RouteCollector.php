<?php

namespace Route;

class RouteCollector
{
    /**
     * Used as part of the workflow in the Router
     *
     * Makes use of the RouteParser & DataGenerator and returns the parsed data
     *
     * @param string $route
     * @return array
     */
    public function addRoute(string $route): array
    {
        $parser = new RouteParser;
        $routeParsed = $parser->parse($route);

        $generator = new DataGenerator;

        $generator->addRoute($routeParsed);
        return $generator->getData();
    }
}
