<?php

namespace Gjoni\Router;

use Gjoni\Router\Exception\ClassNotFoundException;
use Gjoni\Router\Exception\MethodNotCalledException;
use Gjoni\Router\Exception\MethodNotAllowedException;
use Gjoni\Router\Interfaces\Dispatcher as DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    private ?array $argument;

    /**
     * @inheritDoc
     */
    public function dispatch(array $routerInput)
    {
        # Was there a match?
        if (empty($routerInput["parsed"])) {
            return self::NOT_FOUND;
        }

        # TODO HEAD requests- look at old commit
        # If yes, does the method correspond?
        if ($routerInput["route_method"] == $routerInput["request_method"]) {

            foreach ($routerInput["parsed"] as $routeGroup) {
                # Check if dynamic route
                if (isset($routerInput["parsed"]["dynamic"])) {
                    $this->argument = $routeGroup["params"];
                }
            }

            # If the handler is a controller & method
            if (is_string($routerInput["handler"])) {
                $this->dispatchClass($routerInput);
            } elseif (is_callable($routerInput["handler"])) { # If the handler is a callback
                 $this->dispatchCallable($routerInput);
            }

            return self::FOUND;
        } else {
            http_response_code(405);

            return [
                "exception" => new MethodNotAllowedException()
            ];
        }
    }

    private function dispatchClass($routerInput) {
        # Split handler on @- limited at two
        $splitHandler = preg_split("/[@]/", $routerInput["handler"], 2, PREG_SPLIT_NO_EMPTY);
        $controller = $splitHandler[0];

        # Was the method passed?
        if (isset($splitHandler[1])) {
            $method = $splitHandler[1];
            $map = $routerInput["map"];

            if (class_exists("$map\\$controller")) {
                $class = "$map\\$controller";
                $class = new $class();

                if (!empty($this->argument)) {
                    call_user_func_array(array($class, "$method"), $this->argument);
                } else {
                    call_user_func(array($class, "$method"));
                }
            } else {
                throw new ClassNotFoundException;
            }
        } else {
            throw new MethodNotCalledException;
        }
    }

    private function dispatchCallable($routerInput) {
        if (!empty($this->argument)) {
            call_user_func_array($routerInput["handler"], $this->argument);
        } else {
            call_user_func($routerInput["handler"]);
        }
    }
}
