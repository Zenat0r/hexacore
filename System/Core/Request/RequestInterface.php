<?php

use Hexacore\Core\Request;

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
     * @return array
     */ 
    public function getQueries() : array;

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
     * @return array
     */
    public function getPosts() : array;

    /**
     * Return specific value of $_POST or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function getPost(string $name);

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
    public function getServers() : array;

    /**
     * Return specific value of $_SERVER or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function getServer(string $name);

    /**
     * Return the $_COOKIE array
     *
     * @return array
     */
    public function getCookies() : array;

    /**
     * Return specific value of $_COOKIE or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function getCookie(string $name);

    /**
     * Return the $_FILES array
     *
     * @return array
     */
    public function getFiles() : array;

    /**
     * Return specific value of $_FILES or null
     *
     * @param string $name
     * @return mixed|null
     */
    public function getFile(string $name);
}