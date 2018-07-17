<?php

namespace Hexacore\Core\Config;

interface ConfigInterface
{
    /**
     * @param $filepath string path of the configuration file
     *
     * @return array configuration file as an formated array
     */
    public static function get(string $filepath) : array;
}
