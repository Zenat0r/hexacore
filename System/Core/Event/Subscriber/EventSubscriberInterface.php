<?php

namespace Hexacore\Core\Event\Subscriber;

interface EventSubscriberInterface
{
    /**
     * tell the dispatch whether it is subscribed to the event or not
     *
     * @param string $event
     * @return bool
     */
    public function isNotify(string $event) : bool;

    /**
     * function exectuted when the event is dispatch
     *
     * @param Object $object
     * @return void
     */
    public function dispatch($object);
}