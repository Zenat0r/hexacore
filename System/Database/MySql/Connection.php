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
    /**
     * @inheritdoc
     */
    public function establish()
    {
        return new \PDO("mysql:host={$this->host}:{$this->port};dbname={$this->db}", $this->user, $this->pwd);
    }
}