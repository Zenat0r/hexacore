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
    public static function get(string $name = "system") : array
    {
        $filepath = __DIR__ . "/../../../App/config/" . $name . ".json";
        if (self::$instance === null) {
            self::$instance = new JsonConfig($filepath);
        } elseif (empty($this->params[$filepath])) {
            $this->setParm($filepath);
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

    private function getParam(string $filepath): array
    {
        return $this->params[$filepath];
    }
}
