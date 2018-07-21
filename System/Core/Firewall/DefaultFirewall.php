<?php

namespace Hexacore\Core\Firewall;

use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Config\JsonConfig;

class DefaultFirewall implements FirewallInterface
{
    public function check(RequestInterface $request, bool $throw = true) : bool
    {
        $https = $request->getServer("HTTPS");
        $config = JsonConfig::get("app")["https"] ?? false;

        if ($config
            && !empty($https) && $https != "off") {
            return true;
        } elseif ($config === false && (empty($https) || $https === "off")) {
            return true;
        }

        if ($throw) ;//exepection;
    }
}
