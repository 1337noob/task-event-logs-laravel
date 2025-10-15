<?php

namespace App\Broker;

interface HandlerInterface
{
    public function handle(string $msg): void;
    public function getQueueName(): string;
}
