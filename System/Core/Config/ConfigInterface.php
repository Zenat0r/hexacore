<?php

namespace Hexacore\Core\Config;

interface ConfigInterface
{
    /**
     * Return the configuration as an array by giving the name of a file.
     * The file must be located in App/config/
     * Subfolders cas be used to e.g : service/config
     * Caution the file extension is not needed, is this handled by the
     * specific implementation of this interface
     *
     * @return ConfigInterface
     */
    public static function getInstance(): ConfigInterface;

    public function setFile(string $path) : ConfigInterface;

    public function getFile();

    public function toArray();
}
