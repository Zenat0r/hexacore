<?php

namespace Hexacore\Core\Event\Dispatcher;

use Hexacore\Core\Event\Subscriber\EventSubscriberInterface;

class EventManager implements EventDispatcherInterface
{
    private $subscribers = [];

    public function addSubscriber(EventSubscriberInterface $subscriber) : void
    {
        array_push($this->subscribers, $subscriber);
    }

    public function removeSubscriber(EventSubscriberInterface $subscriber) : void
    {
        //why remove ?
    }

    public function notify(string $event) : void
    {
        foreach ($this->subscribers as $sub) {
            if ($sub->isNotify($event)) {
                $sub->dispatch();
            }
        }
    }
}
