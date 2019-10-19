<?php


namespace Hexacore\Database\MongoDB;

use Hexacore\Core\Model\Connection\AbstractConnection;


class MongoDbConnection extends AbstractConnection
{

    /**
     * @inheritdoc
     */
    public function establish()
    {
        $client = new \MongoDB\Client("mongodb://{$this->user}:{$this->pwd}@{$this->host}:{$this->port}");

        return $client->{$this->db};
    }
}