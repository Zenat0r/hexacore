<?php

namespace Hexacore\Database\MySql;

use Hexacore\Core\Model\Connection\AbstractConnection;


/**
 * Implementation of connection for the MySQL database using the native php PDO
 *
 * Class Connection
 * @package Hexacore\Database\MySql
 */
class Connection extends AbstractConnection
{
    private $pdo;

    /**
     * @inheritdoc
     */
    public function establish()
    {
        if (is_null($this->pdo)) {
            $this->pdo = new \PDO("mysql:host={$this->host}:{$this->port};dbname={$this->db}", $this->user, $this->pwd);
        }

        return $this->pdo;
    }
}