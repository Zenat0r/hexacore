<?php

namespace Hexacore\Core;

class Core
{
    private static $core;

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
