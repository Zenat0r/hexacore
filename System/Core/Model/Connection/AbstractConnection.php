<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 19/03/19
 * Time: 13:48
 */

namespace Hexacore\Core\Model\Connection;


use Hexacore\Core\Config\JsonConfig;

/**
 * Abstract implementation of ConnectionInterface.
 * This implementation must be extended to be usable with the database drive of you choice.
 *
 * Class AbstractConnection
 * @package Hexacore\Core\Model\Connection
 */
abstract class AbstractConnection implements ConnectionInterface
{
    protected $db;
    protected $user;
    protected $pwd;
    protected $host;
    protected $port;

    /**
     * AbstractConnection constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->db = JsonConfig::get("database")["dbname"];
        if (empty($this->db)) throw new \Exception("Connection configuration wrong");

        $this->user = JsonConfig::get("database")["user"] ?? "root";
        $this->pwd = JsonConfig::get("database")["password"] ?? "";
        $this->host = JsonConfig::get("database")["host"] ?? "127.0.0.1";
        $this->port = JsonConfig::get("database")["port"] ?? 3306;
    }

    /**
     * @inheritdoc
     */
    abstract public function establish();

    /**
     * @inheritdoc
     */
    public function setDb(string $name): ConnectionInterface
    {
        $this->db = $name;
    }

    /**
     * @inheritdoc
     */
    public function setUser(string $name): ConnectionInterface
    {
        $this->user = $name;
    }

    /**
     * @inheritdoc
     */
    public function setPwd(string $pwd): ConnectionInterface
    {
        $this->pwd = $pwd;
    }

    /**
     * @inheritdoc
     */
    public function setHost(string $host): ConnectionInterface
    {
        $this->host = $host;
    }

    /**
     * @inheritdoc
     */
    public function setPort(int $port): ConnectionInterface
    {
        $this->port = $port;
    }
}