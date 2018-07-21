<?php

namespace Hexacore\Core\Firewall;

use Hexacore\Core\Request\RequestInterface;

interface FirewallInterface
{
    public function check(RequestInterface $request, bool $throw = true) : bool;
}
