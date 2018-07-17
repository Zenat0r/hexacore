<?php

namespace Hexacore\Core\Config;

interface ConfigInterface
{
    public static function get(string $filepath) : self;
}
