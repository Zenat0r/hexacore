<?php


namespace Hexacore\Command\IO;


interface IOInterface
{
    public static function write($data): void;

    public static function read();
}