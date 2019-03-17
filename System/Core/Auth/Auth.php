<?php

namespace Hexacore\Core\Auth;

use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Response\Response;

class Auth implements AuthInterface
{
    const defaultRole = "ANONYMOUS";

    private $roles;
    private $storage;

    public function __construct()
    {
        $this->roles = JsonConfig::get("app")["Auth"]["roles"] ?? [];
        array_push($this->roles, Auth::defaultRole);
    }

    public function isGranted(string $role) : bool
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->roles)) {
            throw new \Exception("Role doesn't exist", Response::UNAUTHORIZED);
        }

        if ($this->storage->get("USER_ROLE") === $role) {
            return true;
        }

        return false;
    }

    public function getToken() : ?string
    {
        $token = $this->storage->get("token") ?? null;

        return $token;
    }

    public function authenticate(RequestInterface $request) : void
    {
        $this->storage = $request->getSession();
        $token = $this->getToken();

        if (null === $token) {
            $token = $this->storage->add("token", md5(uniqid()));

            $this->storage->add("USER_ROLE", Auth::defaultRole);
        }
    }
}
