<?php

namespace Test\Controllers;

class TestController
{
    private $someProperty;

    public function __construct($someProperty)
    {
        $this->someProperty = $someProperty;
    }

    public function getProperty()
    {
        return $this->someProperty;
    }

}