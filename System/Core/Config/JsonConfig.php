<?php

namespace Hexacore\Core\Config;

class JsonConfig implements ConfigInterface
{
    private $params;
    private static $instance;

    public static function get(string $filepath = __DIR__ . "/../../App/config/app.json") : array
    {
        if (is_null(self::$instance)) {
            self::$instance = new JsonConfig($filepath);
        }

        return (self::$instance)->getParams();
    }

    private function __contructor(string $filepath) : void
    {
        $string = file_get_contents($filepath);
        $this->params = json_decode($string, true);
    }

    private function getParams()
    {
        return $this->params;
    }
}
