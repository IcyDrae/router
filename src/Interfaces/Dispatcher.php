<?php


namespace Gjoni\Router\Interfaces;

use Gjoni\Router\Exception\MethodNotCalledException;
use Gjoni\Router\Exception\ClassNotFoundException;

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
