<?php

namespace Hexacore\Core\Config;

class JsonConfig implements ConfigInterface
{
    /** @var array */
    private $params;
    
    /** @var JsonConfig */
    private static $instance;

    /**
     *  {@inheritDoc}
     */
    public static function get(string $name = "app") : array
    {
        $filepath = "../../../App/config/" . $name . ".json";
        if (is_null(self::$instance)) {
            self::$instance = new JsonConfig($filepath);
        }

        return (self::$instance)->getParam($filepath);
    }

    private function __contructor(string $filepath) : void
    {
        $string = file_get_contents($filepath);
        $this->params[$filepath] = json_decode($string, true);
    }

    private function getParam(string $filepath): array
    {
        return $this->params[$filepath];
    }
}
