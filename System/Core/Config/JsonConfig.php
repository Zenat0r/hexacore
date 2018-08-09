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
    public static function get(string $name = "system") : iterable
    {
        $filepath = __DIR__ . "/../../../App/config/$name.json";
        if (self::$instance === null) {
            self::$instance = new JsonConfig($filepath);
        } elseif (empty(self::$instance->params[$filepath])) {
            self::$instance->setParm($filepath);
        }

        return self::$instance->getParam($filepath);
    }

    private function __construct(string $filepath)
    {
        $this->setParm($filepath);
    }

    private function setParm(string $filepath) : void
    {
        $string = file_get_contents($filepath);
        $this->params[$filepath] = json_decode($string, true);
    }

    private function getParam(string $filepath): iterable
    {
        return $this->params[$filepath];
    }
}
