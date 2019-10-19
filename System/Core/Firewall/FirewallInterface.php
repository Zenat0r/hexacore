<?php

namespace Hexacore\Core\Firewall;

use Hexacore\Core\Request\RequestInterface;

interface FirewallInterface
{
    /**
     * Check if the request header are conform to the application configuration
     *
     * @param RequestInterface $request
     * @param boolean $throw
     * @return boolean
     */
    public function check(RequestInterface $request, bool $throw = true): bool;
}
