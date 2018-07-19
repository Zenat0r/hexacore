<?php

namespace Hexacore\Core\Event\Subscriber;

interface EventSubscriberInterface
{
    /**
     * tell the dispatch whether it is subscribed to the event or not
     *
     * @param string $event
     * @return boolean
     */
    public function isNotify(string $event) : boolean;

    /**
     * function exectuted when the event is dispatch
     *
     * @return void
     */
    public function dispatch();
}