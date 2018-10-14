<?php

namespace Hexacore\Core\Auth;

use Hexacore\Core\Request\RequestInterface;

interface AuthInterface
{
    /**
     * Check is a user has the right depentin on a role
     *
     * @param string $role
     * @return boolean
     */
    public function isGranted(string $role) : bool;

    /**
     * Return the Auth unique itentificator
     *
     * @return string|null
     */
    public function getToken() : ?string;

    /**
     * Authenticate the client
     *
     * @param RequestInterface $request
     * @return void
     */
    public function authenticate(RequestInterface $request) : void;
}
