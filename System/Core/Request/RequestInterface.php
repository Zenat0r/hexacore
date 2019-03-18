<?php

namespace Hexacore\Core\Request;

use Hexacore\Core\Storage\Cookie\CookieInterface;
use Hexacore\Core\Storage\Session\Session;

/**
 * Interface RequestInterface
 * @package Hexacore\Core\Request
 */
interface RequestInterface
{
    /**
     * Return the request sent to the server
     *
     * @return string
     */
    public function getFullRequest() : string;

    /**
     * Return the method name (POST,PUT,GET,DELETE,PATCH)
     *
     * @return string
     */
    public function getMethod() : string;

    /**
     * Return a specific header
     *
     * @param string $name
     * @throws Exception
     * @return string
     */
    public function getHeader(string $name) : string;

    /**
     * Return the $_GET array
     *
     * @return array|null
     */
    public function getQueries() : ?iterable;

    /**
     * Return specific value of $_GET or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function getQuery(string $name);

    /**
     * Return the $_POST array
     *
     * @return array|null
     */
    public function getPosts() : ?iterable;

    /**
     * Return specific value of $_POST or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function getPost(string $name);

    /**
     * Return request body
     *
     * @return void
     */
    public function getPayload();
    /**
     * Return a session object
     *
     * @return Session
     */
    public function getSession() : Session;

    /**
     * Return the $_SERVER array
     *
     * @return array
     */
    public function getServers() : iterable;

    /**
     * Return specific value of $_SERVER or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function getServer(string $name);

    /**
     * Return cookie object
     *
     * @return CookieInterface
     */
    public function getCookie(): CookieInterface;

    /**
     * Return the $_FILES array
     *
     * @return array|null
     */
    public function getFiles() : ?iterable;

    /**
     * Return specific value of $_FILES or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function getFile(string $name);
}
