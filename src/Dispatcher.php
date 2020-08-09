<?php
namespace Route;

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
            #var_dump(class_exists("$map\TestController"));

            # Split handler using character
            $splitHandler = explode("@", "$handler@");
            $controller = $splitHandler[0];

            # Was the method passed?
            if ($splitHandler[1]) {
                $method = $splitHandler[1];

                var_dump($method);
            } else {
                return "Method did not get called.";
            }

            // TODO find classes in namespace and dispatch

        }

        # If the handler is a callback
        if (is_callable($handler)) {
            call_user_func($handler);
        }

    }
}
