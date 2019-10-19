<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 19/03/19
 * Time: 13:48
 */

namespace Hexacore\Core\Model\Connection;


use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Exception\Model\ConnectionConfigException;

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
        $config = JsonConfig::getInstance()->setFile('database')->toArray();

        $this->db = $config["dbname"];

        if (empty($this->db)) {
            throw new ConnectionConfigException("Connection configuration wrong");
        }

        $this->user = $config["user"] ?? "root";
        $this->pwd = $config["password"] ?? "";
        $this->host = $config["host"] ?? "127.0.0.1";
        $this->port = $config["port"] ?? 3306;
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

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setUser(string $name): ConnectionInterface
    {
        $this->user = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setPwd(string $pwd): ConnectionInterface
    {
        $this->pwd = $pwd;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHost(string $host): ConnectionInterface
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setPort(int $port): ConnectionInterface
    {
        $this->port = $port;

        return $this;
    }
}