<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once realpath(dirname(__FILE__).'/system/core/loader.php');

$loader = new Loader();
$loader->autoload();

$route = new Route();
$route->routeQuery();
