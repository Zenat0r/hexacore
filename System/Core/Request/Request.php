<?php

namespace Hexacore\Core\Request;

use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Storage\Session\Session;

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
        if(is_null(self::$instance)){
            self::$instance = new Request();
        }

        return self::$instance;
    }

    private function __contructor() : void
    {
        $this->server = $_SERVER;
        $this->fulleRequest = (isset($this->server['HTTPS']) && $this->server['HTTPS'] === 'on' ? "https" : "http") . "://$this->server[HTTP_HOST]$this->server[REQUEST_URI]";
        $this->method = $this->server["REQUEST_METHOD"];
        $this->header = $this->getHeaders();
        $this->queries = $_GET;
        $this->posts = $_POST;
        $this->files = $_FILES;
        $this->cookies = $_COOKIE;
    }

    private function getHeaders() : array
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

    public function getQueries() : array
    {
        return $this->queries;
    }

    public function getQuery(string $name)
    {
        return $this->queries[$name];
    }

    public function getPosts() : array
    {
        return $this->posts;
    }

    public function getPost(string $name)
    {
        return $this->posts[$name];
    }

    public function getSession() : Session
    {
        if(is_null($this->session)){
            $this->session = new Session();
        }

        return $this->session;
    }

    public function getServers() : array
    {
        return $this->server;
    }

    public function getServer(string $name)
    {
        return $this->server[$name];
    }

    public function getCookies() : array
    {
        return $this->cookies;
    }

    public function getCookie(string $name)
    {
        return $this->cookies[$name];
    }

    public function getFiles() : array
    {
        return $this->files;
    }

    public function getFile(string $name)
    {
        return $this->files[$name];
    }
}