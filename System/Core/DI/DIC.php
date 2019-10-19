<?php

namespace Hexacore\Core\DI;

use Hexacore\Core\Config\ConfigInterface;
use Hexacore\Core\Config\JsonConfig;

class DIC
{
    private static $instance;

    /**
     * @var ConfigInterface
     */
    private $config;

    public static function start(): DIC
    {
        if (is_null(self::$instance)) {
            self::$instance = new DIC();

            self::$instance->config = JsonConfig::getInstance()->setFile('dependencyInjection')->toArray();
        }

        return self::$instance;
    }

    /**
     * @param string $name
     * @return object
     * @throws \ReflectionException
     */
    public function get(string $name)
    {
        $reflectedClass = new \ReflectionClass($name);

        if ($reflectedClass->isInstantiable()) {
            return $this->instantiate($reflectedClass);
        } elseif ($reflectedClass->isInterface() || $reflectedClass->isAbstract()) {
            $class = $this->config['autowiring'][$name];

            return $this->instantiate(new \ReflectionClass($class));
        } else {
            //what the hell is that
        }
    }

    /**
     * @param \ReflectionClass $reflectedClass
     * @return object
     * @throws \ReflectionException
     */
    private function instantiate(\ReflectionClass $reflectedClass)
    {
        $reflectedConstructor = $reflectedClass->getConstructor();

        if ($reflectedConstructor) {
            $parameters = [];

            foreach ($reflectedConstructor->getParameters() as $param) {
                if ($param->getClass()) {
                    $parameters[] = $this->get($param->getClass()->getName());
                } else {
                    $classNamespace = $reflectedClass->getName();

                    if (isset($this->config[$classNamespace][$param->getName()])) {
                        $parameters[] = $this->config[$classNamespace][$param->getName()];
                    } else {
                        $parameters[] = $param->getDefaultValue();
                    }
                }
            }
            return $reflectedClass->newInstanceArgs($parameters);
        } else {
            return $reflectedClass->newInstance();
        }
    }
}
