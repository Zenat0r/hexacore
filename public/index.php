<?php

use Hexacore\Core\Core;
use Hexacore\Autoloader;
use Hexacore\Core\Request\Request;
use Hexacore\Core\Event\Dispatcher\EventManager;

require __DIR__ . "/../System/Autoloader.php";

Autoloader::register();

$request = Request::get();
$hexacore = Core::boot(new EventManager);
$hexacore->handle($request);
