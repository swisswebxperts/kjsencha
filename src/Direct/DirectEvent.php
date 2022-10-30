<?php

namespace KJSencha\Direct;

use Laminas\EventManager\Event;

class DirectEvent extends Event
{
    const EVENT_DISPATCH_RPC    = 'dispatch.rpc';
}