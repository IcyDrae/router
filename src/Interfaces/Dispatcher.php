<?php


namespace Route\Interfaces;


interface Dispatcher
{
    /**
     * @param $string
     * @return mixed
     */
    public function getRoute($string);
}