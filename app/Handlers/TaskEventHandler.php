<?php

namespace App\Handlers;

use App\Broker\HandlerInterface;
use App\Models\Log;

class TaskEventHandler implements HandlerInterface
{
    public function handle(string $msg): void
    {
        $newLog = json_decode($msg, true);

        Log::create([
            'event' => $newLog['event'],
            'task_id' => $newLog['task_id'],
            'user_id' => $newLog['user_id'],
        ]);
    }

    public function getQueueName(): string
    {
        return 'task-events';
    }
}
