<?php

namespace Hexacore\Core\Event\Dispatcher;

use Hexacore\Core\Event\Subscriber\EventSubscriberInterface;

class EventManager implements EventDispatcherInterface
{
    const CORE_BOOT = "CORE_BOOT";
    const CORE_FIREWALL_PRE_CHECK = "CORE_FIREWALL_PRE_CHECK";
    const CORE_FIREWALL_POST_CHECK = "CORE_FIREWALL_POST_CHECK";
    const CORE_AUTH_PRE_AUTHENTICATE = "CORE_AUTH_PRE_AUTHENTICATE";
    const CORE_AUTH_POST_AUTHENTICATE = "CORE_AUTH_POST_AUTHENTICATE";
    const CORE_ROUTER_PRE_MATCH = "CORE_ROUTER_PRE_MATCH";
    const CORE_ROUTER_POST_MATCH = "CORE_ROUTER_POST_MATCH";

    private $subscribers = [];

    public function addSubscriber(EventSubscriberInterface $subscriber) : void
    {
        array_push($this->subscribers, $subscriber);
    }

    public function removeSubscriber(EventSubscriberInterface $subscriber) : void
    {
        //why remove ?
    }

    public function notify(string $event, $object = null) : void
    {
        foreach ($this->subscribers as $sub) {
            if ($sub->isNotify($event)) {
                $sub->dispatch($object);
            }
        }
    }
}
