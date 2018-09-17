<?php

namespace Hexacore\Core\Request;

use Hexacore\Core\Storage\Session\Session;
use Hexacore\Core\Storage\Cookie\Cookie;
use Hexacore\Core\Storage\Cookie\CookieInterface;

class Request implements RequestInterface
{
    private static $instance;

    private $fulleRequest;

    private $method;

    private $header;

    private $queries;

    private $posts;

    private $session;

    private $files;

    private $server;

    private $cookies;

    public static function get() : Request
    {
        if (is_null(self::$instance)) {
            self::$instance = new Request();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->server = $_SERVER;
        $this->fulleRequest = (isset($this->server['HTTPS']) && $this->server['HTTPS'] === 'on' ? "https" : "http") . "://$this->server[HTTP_HOST]$this->server[REQUEST_URI]";
        $this->method = $this->server["REQUEST_METHOD"];
        $this->header = $this->getHeaders();
        $this->queries = $_GET;
        $this->posts = $_POST;
        $this->files = $_FILES;
    }

    private function getHeaders() : iterable
    {
        $server = $this->server ?? $_SERVER;

        foreach ($server as $key => $value) {
            if (preg_match("/^HTTP_.*$/", $key)) {
                $headers[str_replace("HTTP_", "", $key)] = $value;
            }
        }

        return $headers;
    }

    public function getFullRequest() : string
    {
        return $this->fulleRequest;
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getHeader(string $name) : string
    {
        $name = strtoupper($name);
        return $this->header[$name];
    }

    public function getQueries() : ?iterable
    {
        return $this->queries;
    }

    public function getQuery(string $name)
    {
        return $this->queries[$name];
    }

    public function getPosts() : ?iterable
    {
        return $this->posts;
    }

    public function getPost(string $name)
    {
        return $this->posts[$name];
    }

    public function getSession() : Session
    {
        if (is_null($this->session)) {
            $this->session = new Session();
        }

        return $this->session;
    }

    public function getServers() : iterable
    {
        return $this->server;
    }

    public function getServer(string $name)
    {
        return $this->server[$name];
    }

    public function getCookie(): CookieInterface
    {
        if (is_null($this->cookie)) {
            $this->cookie = new Cookie();
        }

        return $this->cookie;
    }

    public function getFiles() : ?iterable
    {
        return $this->files;
    }

    public function getFile(string $name)
    {
        return $this->files[$name];
    }
}
