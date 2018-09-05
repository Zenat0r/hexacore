<?php

namespace Hexacore\Core\Auth;

use Hexacore\Core\Storage\StorageInterface;
use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Response\Response;

class Auth implements AuthInterface
{
    const defaultRole = "ANONYMOUS";

    private $roles;

    public function __construct()
    {
        $this->roles = JsonConfig::get("app")["Auth"]["roles"] ?? [];
        array_push($this->roles, Auth::defaultRole);
    }

    public function isGranted(StorageInterface $storage, string $role) : bool
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->roles)) {
            throw new \Exception("Role doesn't exist", Response::UNAUTHORIZED);
        }

        if ($storage->get("USER_ROLE") === $role) {
            return true;
        }

        return false;
    }

    public function getToken(StorageInterface $storage) : ?string
    {
        $token = $storage->get("token") ?? null;

        return $token;
    }

    public function authenticate(StorageInterface $storage) : void
    {
        $token = $this->getToken($storage);

        if (null === $token) {
            $token = $storage->add("token", md5(uniqid()));
        }

        $storage->add("USER_ROLE", Auth::defaultRole);
    }
}
