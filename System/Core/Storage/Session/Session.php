<?php

namespace Hexacore\Core\Storage\Session;

use Hexacore\Core\Storage\StorageInterface;

class Session implements SessionInterface, StorageInterface
{
    public function __construct()
    {
        $this->start();
    }
    public function start() : void
    {
        session_start();
    }

    public function destroy() : void
    {
        session_unset();
        session_destroy();
    }

    public function add(string $name, $value = null)
    {
        $value = $value ?? $name;
        if (null !== $_SESSION[$name]) {
            return false;
        } else {
            $_SESSION[$name] = $value;
            return $value;
        }
    }

    public function remove(string $name) : bool
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
            return true;
        } else {
            return false;
        }
    }

    public function get(string $name)
    {
        return $_SESSION[$name];
    }
}
