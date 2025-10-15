<?php

namespace App\Broker\RabbitMQ;

use App\Broker\BrokerInterface;
use App\Broker\HandlerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQBroker implements BrokerInterface
{
    public function __construct(
        private readonly AMQPStreamConnection $connection,
    )
    {
    }

    public function consume(HandlerInterface $handler): void
    {
        $channel = $this->connection->channel();

        $channel->queue_declare($handler->getQueueName(), false, false, false, false);

        $callback = function ($msg) use ($handler) {
            /** @var AMQPMessage $msg * */
            $handler->handle($msg->getBody());
        };

        $channel->basic_consume($handler->getQueueName(), '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}
