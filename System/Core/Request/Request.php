<?php

namespace Hexacore\Core\Request;

use Hexacore\Core\Storage\Cookie\Cookie;
use Hexacore\Core\Storage\Cookie\CookieInterface;
use Hexacore\Core\Storage\Session\Session;

class Request implements RequestInterface
{
    private static $instance;

    protected $fullRequest;

    protected $method;

    protected $header;

    protected $queries;

    protected $posts;

    protected $payload;

    protected $session;

    protected $files;

    protected $server;

    protected $cookies;

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
        $this->fullRequest = (isset($this->server['HTTPS']) && $this->server['HTTPS'] === 'on' ? "https" : "http") . "://{$this->server['HTTP_HOST']}{$this->server['REQUEST_URI']}";
        $this->method = $this->server["REQUEST_METHOD"];
        $this->header = $this->getHeaders();
        $this->queries = $_GET;
        $this->posts = $_POST;
        $this->payload = file_get_contents("php://input");
        $this->files = $_FILES;
    }

    private function getHeaders() : iterable
    {
        $serverData = $this->server ?? $_SERVER;

        foreach ($serverData as $key => $value) {
            if (preg_match("/^HTTP_.*$/", $key)) {
                $headers[str_replace("HTTP_", "", $key)] = $value;
            } else {
                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    public function getFullRequest() : string
    {
        return $this->fullRequest;
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

    public function getPayload()
    {
        return $this->payload;
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
        if (is_null($this->cookies)) {
            $this->cookies = new Cookie();
        }

        return $this->cookies;
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
