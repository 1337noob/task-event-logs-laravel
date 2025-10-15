<?php

namespace App\Workers;

use App\Broker\BrokerInterface;
use App\Handlers\TaskEventHandler;

class TaskWorker

{
    public function __construct(
        private readonly BrokerInterface $broker,
    )
    {
    }

    public function run(): void
    {
        $handler = new TaskEventHandler();

        $this->broker->consume($handler);
    }
}
