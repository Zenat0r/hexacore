<?php


namespace Hexacore\Command\IO;


class ConsoleIO implements IOInterface
{

    public static function write($data): void
    {
        if (!is_string($data)) {
            throw new \InvalidArgumentException('Data not a string');
        }
        fwrite(STDOUT, $data);
    }
    public static function writeLn($data): void
    {
        if (!is_string($data)) {
            throw new \InvalidArgumentException('Data not a string');
        }
        fwrite(STDOUT, $data . "\n");
    }

    public static function read()
    {
        return rtrim(fgets(STDIN), PHP_EOL);
    }

    public static function readHidden()
    {
        if ('Linux' !== PHP_OS) {
            throw new \Exception('OS not supported');
        }
        system('stty -echo');
        $value =  fgets(STDIN);
        system('stty echo');

        return rtrim($value, PHP_EOL);
    }
}