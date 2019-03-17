<?php

namespace Hexacore\Core\Firewall;

use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Response\Response;

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

        if ($throw) throw new \Exception("Connexion not allowed", Response::FORBIDDEN);//exepection;

        return false;
    }
}
