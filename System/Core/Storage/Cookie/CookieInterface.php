<?php

namespace Hexacore\Core\Storage\Cookie;

interface CookieInterface
{
    /**
     * Set cookie path
     *
     * @param string $path
     * @return CookieInterface
     */
    public function setPath(string $path): CookieInterface;

    /**
     * Set cookie timeout (timestamp)
     * for exemple time() + 3600 for on hour
     *
     * @param integer $timeout
     * @return CookieInterface
     */
    public function setTimeout(int $timeout): CookieInterface;

    /**
     * Set security level, if true cookie can only be send through
     * TLS/SSL http.
     *
     * @param boolean $level
     * @return CookieInterface
     */
    public function secured(bool $level): CookieInterface;

    /**
     * Set httponly, if true allow javascript to use this cookie.
     *
     * @param boolean $level
     * @return CookieInterface
     */
    public function httpOnly(bool $level): CookieInterface;
}
