<?php

namespace Hexacore\Core\Model\Connection;

interface ConnectionInterface
{
    public function setDb(string $name): void;

    public function setUser(string $name): void;

    public function setPwd(string $pwd): void;

    public function setHost(string $host): void;

    public function setPort(int $port): void;

    public function establish();
}