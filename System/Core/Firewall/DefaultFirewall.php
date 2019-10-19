<?php

namespace Hexacore\Core\Firewall;

use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Exception\Firewall\UnauthorizedFirewallException;
use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Response\Response;

class DefaultFirewall implements FirewallInterface
{
    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function check(RequestInterface $request, bool $throw = true): bool
    {
        $https = $request->getServer("HTTPS");
        $config = JsonConfig::getInstance()->setFile('app')->toArray()["https"] ?? false;

        if ($config
            && !empty($https) && $https !== "off"
            || $config === false && (empty($https) || $https === "off")) {
            return true;
        }

        if ($throw) {
            throw new UnauthorizedFirewallException("Connexion not allowed", Response::FORBIDDEN);
        }

        return false;
    }
}
