<?php


namespace Route\Exception;

use Exception;
use Throwable;


class InvalidRouteException extends Exception
{
    public function __construct($message = "", $code = 405, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = "Route not found.";
    }

}
