<?php


namespace Route\Interfaces;


interface RouteParser
{
    public function parse(string $route): array;

}