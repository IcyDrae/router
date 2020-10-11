<?php


namespace Gjoni\Router\Interfaces;

use Gjoni\Router\Exception\MethodNotCalledException;
use Gjoni\Router\Exception\ClassNotFoundException;

interface DispatcherInterface
{
    public const NOT_FOUND = 0;
    public const FOUND = 1;

    /**
     * @param array $routerInput
     * @return mixed
     * @throws MethodNotCalledException
     * @throws ClassNotFoundException
     */
    public function dispatch(array $routerInput);
}
