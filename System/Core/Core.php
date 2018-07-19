<?php

namespace Hexacore\Core;

use Hexacore\Core\Config\JsonConfig;


class Core
{
    private static $core;

    private $eventManager;

    public static function getCore() : Core
    {
        if (is_null(self::$core)) {
            self::$core = new Core();
        }
        return self::$core;
    }

    private function __contructor() : void
    {
        
    }
}
