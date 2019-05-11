<?php


namespace Hexacore\Core\Request;


class ForwardRequest extends Request
{
    public function __construct()
    {
    }

    /**
     * @param mixed $method
     * @return ForwardRequest
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param iterable $header
     * @return ForwardRequest
     */
    public function setHeader(iterable $header): ForwardRequest
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param mixed $queries
     * @return ForwardRequest
     */
    public function setQueries($queries)
    {
        $this->queries = $queries;
        return $this;
    }

    /**
     * @param mixed $posts
     * @return ForwardRequest
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * @param false|string $payload
     * @return ForwardRequest
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @param mixed $session
     * @return ForwardRequest
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @param mixed $files
     * @return ForwardRequest
     */
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }

    /**
     * @param mixed $server
     * @return ForwardRequest
     */
    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @param mixed $cookies
     * @return ForwardRequest
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
        return $this;
    }

}