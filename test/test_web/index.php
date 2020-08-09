<?php

error_reporting(E_ALL);

include_once "src/RouteCollector.php";
include_once "src/RouteParser.php";

$rc = new Route\RouteCollector();
$rc->addRoute(["GET", "/user/id/group/id"]);
echo "------------------------------------------------------------------------------------------------";


/*class Test_1 {
    public function returns()
    {
        var_dump([
          "1", "2"
        ]);
    }
}

class Test_2 {
    public function returns_also()
    {
        $test_class_1 = new Test_1;
        $test_class_1->returns();

        return $test_class_1;
    }
}

$test_class_1 = new Test_1;
$test_class_1->returns();
var_dump($test_class_1);*/

#$test_class_2 = new Test_2;
#var_dump($test_class_2);