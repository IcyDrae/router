<?php

namespace Route;

use Route\Exception\ClassNotFoundException;
use Route\Exception\MethodNotCalledException;
use Route\Interfaces\Dispatcher as DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    private $argument;

    /**
     * @inheritDoc
     */
    public function dispatch(array $parsed, $handler, $map)
    {
        # Check if an argument was passed in the router
        foreach ($parsed as $routeGroup) {
            extract($routeGroup);

            /** @var string|null $argument */
            if (isset($argument)) {
                $this->argument = $argument;
            }
        }

        # If the handler is a controller & method
        if (is_string($handler)) {
            # Use mapper to search for classes

            # Split handler on @- limited at two
            $splitHandler = preg_split("/[@]/", $handler, 2, PREG_SPLIT_NO_EMPTY);
            $controller = $splitHandler[0];

            # Was the method passed?
            if (isset($splitHandler[1])) {
                $method = $splitHandler[1];

                if (class_exists("$map\\$controller")) {
                    $class = "$map\\$controller";
                    $class = new $class();

                    ($this->argument ? call_user_func_array(array($class, "$method"), array($this->argument)) : call_user_func(array($class, "$method")));
                } else {
                    throw new ClassNotFoundException;
                }
            } else {
                throw new MethodNotCalledException;
            }
        }

        # If the handler is a callback
        if (is_callable($handler)) {
            ($this->argument ? call_user_func_array($handler, array($this->argument)) : call_user_func($handler));
        }
    }
}
