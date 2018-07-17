<?php

namespace Hexacore\Core;

class Config
{
    private $params;
    private static $instance;

    // Renvoie la valeur d'un paramètre de configuration

    public static function get(string $filepath) : Config
    {
        if (is_null(self::$instance)) {
            self::$instance = new Config($filepath);
        }

        return self::$instance;
    }

    private function __contructor(string $filepath = __DIR__ . "/../../App/config/app.json") : void
    {
        $string = file_get_contents($filepath);
        $this->params = json_decode($string, true);
    }
}
