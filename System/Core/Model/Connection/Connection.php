<?php

namespace Hexacore\Core\Model\Connection;

use Hexacore\Core\Config\JsonConfig;


class Connection implements ConnectionInterface
{
    private $db;
    private $user;
    private $pwd;
    private $host;
    private $port;

    public function __construct()
    {
        $this->db = JsonConfig::get("database")["dbname"];
        if(empty($this->db)) throw new \Exception("Connection configuration wrong");

        $this->user = JsonConfig::get("database")["user"] ?? "root";
        $this->pwd = JsonConfig::get("database")["password"] ?? "";
        $this->host = JsonConfig::get("database")["host"] ?? "127.0.0.1";
        $this->port = JsonConfig::get("database")["port"] ?? 3306;
    }

    public function establish()
    {
        return new \PDO("mysql:host={$this->host}:{$this->port};dbname={$this->db}", $this->user, $this->pwd);
    }

    public function setDb(string $name): void 
    {
        $this->db = $name;
    }

    public function setUser(string $name): void
    {
        $this->user = $name;
    }

    public function setPwd(string $pwd): void
    {
        $this->pwd = $pwd;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function setPort(int $port): void
    {
        $this->port = $port;
    }
}