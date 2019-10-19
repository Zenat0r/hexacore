<?php

namespace Hexacore\Core\Config;

use Hexacore\Core\Exception\Config\MissingFileException;

class JsonConfig implements ConfigInterface
{
    private $file;

    /** @var JsonConfig */
    private static $instance;

    /**
     *  {@inheritDoc}
     */
    public static function getInstance(): ConfigInterface
    {
        if (null === self::$instance) {
            self::$instance = new JsonConfig();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    /**
     * @param string $path
     * @return ConfigInterface
     * @throws MissingFileException
     */
    public function setFile(string $path): ConfigInterface
    {
        $this->file = $path;

        return $this;
    }

    public function getFile()
    {
        $filepath = __DIR__ . "/../../../App/config/{$this->file}.json";

        if (file_exists($filepath)) {
            return file_get_contents($filepath);
        } else {
            throw new MissingFileException("Config file missing");
        }
    }

    /**
     * @return array
     * @throws MissingFileException
     */
    public function toArray()
    {
        $config = json_decode($this->getFile(), true);

        return $this->val($config);
    }

    /**
     * @param $value
     * @return array
     * @throws MissingFileException
     */
    private function val($value)
    {
        if (is_string($value)) {
            if ('#' === $value[0] && '#' === $value[strlen($value) - 1]) {
                $var = substr($value, 0, -1);
                $var = substr($var, 1);

                $string = explode('|', $var, 2);

                $config = $string[0];
                $link = explode('.', $string[1]);

                if ('env' === $config) {
                    $env = implode('_', $link);
                    $env = strtoupper($env);

                    return getenv($env);
                }

                $rootConfigFile = $this->file;

                $subConfig = $this
                    ->setFile($config)
                    ->toArray()
                ;

                $this->setFile($rootConfigFile);

                while ($key = array_shift($link)) {
                    if (is_array($subConfig[$key])) {
                        $subConfig = $subConfig[$key];
                    } else {
                        return $subConfig[$key];
                    }
                }
            } else {
                return $value;
            }
        } elseif (is_array($value)) {
            $result = [];
            foreach ($value as $key => $val) {
                $result[$key] = $this->val($val);
            }
            return $result;
        } else {
            return $value;
        }
    }
}
