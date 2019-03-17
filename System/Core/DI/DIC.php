<?php

namespace Hexacore\Core\DI;

use Hexacore\Core\Config\JsonConfig;

class DIC
{
    private static $instance;

    public static function start(): DIC
    {
        if (is_null(self::$instance)) {
            self::$instance = new DIC();
        }

        return self::$instance;
    }

    public function get(string $name)
    {
        $reflectedClass = new \ReflectionClass($name);

        if ($reflectedClass->isInstantiable()) {
            return $this->instantiate($reflectedClass);
        } elseif ($reflectedClass->isInterface() || $reflectedClass->isAbstract()) {
            $class = JsonConfig::get("autowiring")[$name];

            return $this->instantiate(new \ReflectionClass($class));
        } else {
            //what the hell is that
        }
    }

    private function instantiate(\ReflectionClass $reflectedClass)
    {
        $reflectedConstructor = $reflectedClass->getConstructor();

        if ($reflectedConstructor) {
            $parameters = [];

            foreach ($reflectedConstructor->getParameters() as $param) {
                if ($param->getClass()) {
                    $parameters[] = $this->get($param->getClass()->getName());
                } else {
                    $parameters[] = $param->getDefaultValue();
                }
            }
            return $reflectedClass->newInstanceArgs($parameters);
        } else {
            return $reflectedClass->newInstance();
        }
    }
}
