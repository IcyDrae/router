<?php

namespace Route;

use Route\Exception\ClassNotFoundException;
use Route\Exception\MethodNotCalledException;
use Route\Interfaces\Dispatcher as DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    /**
     * @inheritDoc
     */
    public function dispatch(array $parsed, $handler, $map)
    {
        # If the handler is a controller & method
        if (is_string($handler)) {
            # Use mapper to search for classes

            # Split handler using character
            $splitHandler = preg_split("/[@]/", $handler, 2, PREG_SPLIT_NO_EMPTY); # Limited at two, split using @

            $controller = $splitHandler[0];

            # Was the method passed?
            if (isset($splitHandler[1])) {
                $method = $splitHandler[1];

                if (class_exists("$map\\$controller")) {
                    $class = "$map\\$controller";

                    $class = new $class();

                    call_user_func(array($class, "$method"));
                } else {
                    throw new ClassNotFoundException;
                }

            } else {
                throw new MethodNotCalledException;
            }
        }

        # If the handler is a callback
        if (is_callable($handler)) {
            call_user_func($handler);
        }

    }
}
