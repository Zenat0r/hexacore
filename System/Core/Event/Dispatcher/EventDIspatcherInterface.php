<?php

namespace Hexacore\Core\Event\Dispatcher;

use Hexacore\Core\Event\Subscriber\EventSubscriberInterface;

interface EventDispatcherInterface
{
    /**
     * ADD a subscriber to the eventdispacher list
     *
     * @param EventSubscriberInterface $subscriber
     * @return void
     */
    public function addSubscriber(EventSubscriberInterface $subscriber) : void;

    /**
     * Remove a subscriber form the eventdispacher list
     *
     * @param EventSubscriberInterface $subscriber
     * @return void
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)  : void;

    /**
     * Notify subscriber if it is sensible to
     *
     * @param string $event
     * @return void
     */
    public function notify(string $event): void;
}
