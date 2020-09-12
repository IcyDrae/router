<?php


namespace Gjoni\Router\Exception;

use Exception;
use Throwable;

class MethodNotAllowedException extends Exception
{
    public function __construct($message = "", $code = 405, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = "Method not allowed.";
    }

}
