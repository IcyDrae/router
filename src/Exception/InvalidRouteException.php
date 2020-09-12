<?php


namespace Gjoni\Router\Exception;

use Exception;
use Throwable;


class InvalidRouteException extends Exception
{
    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = "Route not found.";
    }

}
