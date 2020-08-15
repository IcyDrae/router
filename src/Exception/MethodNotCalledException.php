<?php


namespace Route\Exception;

use Exception;
use Throwable;

class  MethodNotCalledException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = "Method was not called, did you forget to separate the class and method with an @?";
    }


}



