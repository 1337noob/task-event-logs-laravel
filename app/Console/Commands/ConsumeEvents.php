<?php

namespace App\Console\Commands;

use App\Broker\BrokerInterface;
use App\Workers\TaskWorker;
use Illuminate\Console\Command;

class ConsumeEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consume-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(BrokerInterface $broker): void
    {
        $this->info('Start task worker');

        $worker = new TaskWorker($broker);

        $worker->run();
    }
}
