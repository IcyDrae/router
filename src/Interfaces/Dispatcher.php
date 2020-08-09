<?php


namespace Route\Interfaces;


interface Dispatcher
{
    /**
     * @param array $parsed
     * @param callable|string $handler
     * @param string $map
     * @return mixed
     */
    public function dispatch(array $parsed, $handler, $map);
}
