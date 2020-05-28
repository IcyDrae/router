<?php


namespace Route\Interfaces;


interface RouteParser
{
    public function parse(String $route): array;

}