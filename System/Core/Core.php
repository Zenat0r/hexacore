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
use Hexacore\Core\DI\DIC;
use Hexacore\Core\Response\Error\ErrorResponse;
use Hexacore\Core\Response\Response;

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

        $dic = DIC::start();
        if (!empty($subs)) {
            foreach ($subs as $sub) {
                $this->eventManager->addSubscriber($dic->get($sub));
            }
        }

        $this->eventManager->notify(EventManager::CORE_BOOT);
    }

    public function handle(RequestInterface $request) : ResponseInterface
    {
        try {
            $dic = DIC::start();

            $firewallName = JsonConfig::get("app")["firewall"] ?? Core::defaultFirewall;
            $firewall = $dic->get($firewallName);

            $this->eventManager->notify(EventManager::CORE_FIREWALL_PRE_CHECK, $firewall);

            if ($firewall instanceof FirewallInterface) {
                $firewall->check($request);
            } else {
                throw new \Exception("Firewall instance uncompatible", Response::INTERNAL_SERVER_ERROR);
            }

            $this->eventManager->notify(EventManager::CORE_FIREWALL_POST_CHECK, $firewall);

            $authName = JsonConfig::get("app")["auth"]["class"] ?? Core::defaultAuth;
            $auth = $dic->get($authName);

            $this->eventManager->notify(EventManager::CORE_AUTH_PRE_AUTHENTICATE, $auth);

            if ($auth instanceof AuthInterface) {
                $auth->authenticate($request);
            } else {
                throw new \Exception("Auth instance uncompatible", Response::INTERNAL_SERVER_ERROR);
            }

            $this->eventManager->notify(EventManager::CORE_AUTH_POST_AUTHENTICATE, $auth);

            $router = new Router($auth);

            $this->eventManager->notify(EventManager::CORE_ROUTER_PRE_MATCH, $router);

            $response = $router->match($request);

            $this->eventManager->notify(EventManager::CORE_ROUTER_POST_MATCH, $response);

            return $response->send($request);
        }catch(\Exception $e){
            $errorResponse = new ErrorResponse($e->getMessage(), [
                "trace" => $e->getTraceAsString(),
                "line" => $e->getLine(),
                "file" => $e->getFile()
            ], $e->getCode());

            return $errorResponse->send($request);
        }
    }
}
