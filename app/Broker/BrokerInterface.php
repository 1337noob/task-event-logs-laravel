<?php

namespace App\Broker;

interface BrokerInterface
{
    public function consume(HandlerInterface $handler): void;
}
