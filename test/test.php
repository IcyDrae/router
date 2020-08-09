<?php

use Route\Router;

require_once __DIR__ . "./../vendor/autoload.php";

if (php_sapi_name() == "cli") {

    Router::get("/login", "TestController@getProperty");


}

echo "\n";
#debug_print_backtrace();
