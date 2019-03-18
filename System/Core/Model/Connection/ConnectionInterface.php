<?php

namespace Hexacore\Core\Model\Connection;

/**
 * Implementations of this interface have to establish the connexion with the database.
 * To do so use the configuration form the framework to set the value need to establish
 * the connexion (as shown with the setter).
 *
 * Interface ConnectionInterface
 * @package Hexacore\Core\Model\Connection
 */
interface ConnectionInterface
{
    /**
     * @param string $name
     * @return ConnectionInterface
     */
    public function setDb(string $name): ConnectionInterface;

    /**
     * @param string $name
     * @return ConnectionInterface
     */
    public function setUser(string $name): ConnectionInterface;

    /**
     * @param string $pwd
     * @return ConnectionInterface
     */
    public function setPwd(string $pwd): ConnectionInterface;

    /**
     * @param string $host
     * @return ConnectionInterface
     */
    public function setHost(string $host): ConnectionInterface;

    /**
     * @param int $port
     * @return ConnectionInterface
     */
    public function setPort(int $port): ConnectionInterface;

    /**
     * This function has to establish a connexion an then return the connexion object
     * used to interact with the database.
     *
     * @return mixed
     */
    public function establish();
}