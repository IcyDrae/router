<?php


namespace Route\Interfaces;

use Route\Exception\MethodNotCalledException;
use Route\Exception\ClassNotFoundException;

interface Dispatcher
{
    /**
     * @param array $parsed
     * @param callable|string $handler
     * @param string $map
     * @return mixed
     * @throws MethodNotCalledException
     * @throws ClassNotFoundException
     */
    public function dispatch(array $parsed, $handler, $map);
}
