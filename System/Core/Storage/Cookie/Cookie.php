<?php

namespace Hexacore\Core\Storage\Cookie;

use Hexacore\Core\Storage\StorageInterface;
use Hexacore\Core\Request\Request;

class Cookie implements CookieInterface, StorageInterface
{
    private $path;
    private $timeout;
    private $secured;
    private $httpOnly;

    public function __construct()
    {
        $this->path = "/";
        $this->timeout = time() + 3600;
        $this->secured = false;
        $this->httpOnly = false;
    }

    public function setPath(string $path) : CookieInterface
    {
        $this->path = $path;

        return $this;
    }

    public function setTimeout(int $timeout): CookieInterface
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function secured(bool $level): CookieInterface
    {
        $this->secured = $level;

        return $this;
    }

    public function httpOnly(bool $level): CookieInterface
    {
        $this->httpOnly = $level;

        return $this;
    }

    public function add(string $name, $value = null)
    {
        setcookie($name, $value, $this->timeout, $this->path, Request::get()->getServer("HTTP_HOST"), $this->secured, $this->httpOnly);
    }

    public function remove(string $name): bool
    {
        if (isset($_COOKIE[$name])) {
            setcookie($name, "", time() - 3600);
            unset($_COOKIE[$name]);
            return true;
        } else {
            return false;
        }
    }

    public function get(string $name)
    {
        return $_COOKIE[$name];
    }
}
