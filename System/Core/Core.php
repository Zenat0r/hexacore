<?php

namespace Hexacore\Core;

use Hexacore\Core\Event\Dispatcher\EventDispatcherInterface;
use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Event\Dispatcher\EventManager;
use Hexacore\Core\Firewall\FirewallInterface;
use Hexacore\Core\Storage\StorageInterface;
use Hexacore\Core\Auth\AuthInterface;
use Hexacore\Core\Router\Router;
use Hexacore\Core\Response\ResponseInterface;

class Core
{
    const defaultFirewall = "Hexacore\\Core\\Firewall\\DefaultFirewall";
    const defaultAuth = "Hexacore\\Core\\Auth\\Auth";

    private static $core;

    private $eventManager;

    public static function boot(EventDispatcherInterface $eventManager) : Core
    {
        if (is_null(self::$core)) {
            self::$core = new Core($eventManager);
        }
        return self::$core;
    }

    private function __construct(EventDispatcherInterface $eventManager)
    {
        $this->eventManager = $eventManager;

        $subs = JsonConfig::get()["eventSubscriber"];
        if (!empty($subs)) {
            foreach ($subs as $sub) {
                $this->eventManager->addSubscriber(new $sub());
            }
        }

        $this->eventManager->notify(EventManager::CORE_BOOT);
    }

    public function handle(RequestInterface $request) : ResponseInterface
    {
        $firewallName = JsonConfig::get("app")["firewall"] ?? Core::defaultFirewall;
        $firewall = new $firewallName();

        $this->eventManager->notify(EventManager::CORE_FIREWALL_PRE_CHECK);

        if ($firewall instanceof FirewallInterface) {
            $firewall->check($request);
        } else {
            //throw error
        }

        $this->eventManager->notify(EventManager::CORE_FIREWALL_POST_CHECK);

        $authName = JsonConfig::get("app")["auth"]["class"] ?? Core::defaultAuth;
        $auth = new $authName();

        $this->eventManager->notify(EventManager::CORE_AUTH_PRE_AUTHENTICATE);

        if ($auth instanceof AuthInterface) {
            $auth->authenticate($request->getSession());
        }

        $this->eventManager->notify(EventManager::CORE_AUTH_POST_AUTHENTICATE);

        $router = new Router($auth);

        $this->eventManager->notify(EventManager::CORE_ROUTER_PRE_MATCH);

        $response = $router->match($request);

        $this->eventManager->notify(EventManager::CORE_ROUTER_POST_MATCH);

        return $response->send($request);
    }
}
