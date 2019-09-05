<?php

namespace Hexacore\Core\Auth;

use Hexacore\Core\Exception\Auth\InvalidRoleAuthException;
use Hexacore\Core\Request\RequestInterface;

interface AuthInterface
{
    /**
     * Check is a user has the right depending on a role
     *
     * @param string $role
     * @return boolean
     * @throws InvalidRoleAuthException
     */
    public function isGranted(string $role): bool;

    /**
     * Return the Auth unique itentificator
     *
     * @return string|null
     */
    public function getToken(): ?string;

    /**
     * Authenticate the client
     *
     * @param RequestInterface $request
     * @return void
     */
    public function authenticate(RequestInterface $request): void;

    /**
     * Set the token liked to a role of the current user for the validation time of the token
     *
     * @param string $role
     * @throws InvalidRoleAuthException
     */
    public function setToken(string $role) : void;

    /**
     * Remove the token liked to this role of the current user for the validation time of the token
     */
    public function removeToken() : void;
}
