<?php

namespace Hexacore\Core\Auth;

use Hexacore\Core\Storage\StorageInterface;
use Hexacore\Core\Request\RequestInterface;

interface AuthInterface
{
    /**
     * Check is a user has the right depentin on a role
     *
     * @param StorageInterface $storage
     * @param string $role
     * @return boolean
     */
    public function isGranted(StorageInterface $storage, string $role) : bool;

    /**
     * Return the Auth unique itentificator
     *
     * @param StorageInterface $storage
     * @return string|null
     */
    public function getToken(StorageInterface $storage) : ?string;

    /**
     * Authenticate the client
     *
     * @param StorageInterface $storage
     * @return void
     */
    public function authenticate(RequestInterface $storage) : void;
}
