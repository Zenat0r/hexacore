<?php

namespace Hexacore\Core;

use Hexacore\Core\Event\Dispatcher\EventDispatcherInterface;
use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Request\RequestInterface;

class Core
{
    private static $core;

    private $eventManager;

    public static function boot() : Core
    {
        if (is_null(self::$core)) {
            self::$core = new Core();
        }
        return self::$core;
    }

    private function __contructor(EventDispatcherInterface $eventManager) : void
    {
        $this->eventManager = $eventManager;

        $subs = JsonConfig::get()["eventSubscriber"];
        
        foreach ($subs as $sub) {
            $this->eventManager->addSubscriber($sub);
        }

        $this->eventManager->notify("CORE_BOOT");
    }

    public function handle(RequestInterface $request) : void
    {
        
    }
}
