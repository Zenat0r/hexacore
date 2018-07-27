<?php

namespace Hexacore;

class Autoloader
{
    public static function register() : void
    {
        spl_autoload_register([__CLASS__, "autoload"]);
    }

    public static function autoload(string $class) : void
    {
        if (preg_match("/^\\\?App\\\/", $class, $matches)) {
            $class = str_replace($matches[0], "", $class);
            $class = str_replace("\\", "/", $class);

            require __DIR__ . "/../App/src/" . $class . ".php";
        } elseif (preg_match("/^\\\?Hexacore\\\/", $class, $matches)) {
            $class = str_replace($matches[0], "", $class);
            $class = str_replace("\\", "/", $class);

            require $class . ".php";
        }
    }
}
