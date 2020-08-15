<?php


namespace Route\Exception;

use Exception;
use Throwable;

class  ClassNotFoundException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = "Called class was not found in namespace.";
    }

}
