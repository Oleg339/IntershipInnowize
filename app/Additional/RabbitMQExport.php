<?php

namespace App\Additional;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQExport
{
    public static function run($class)
    {
        $models = $class::all();
        $models->push(['email' => auth()->user()->email]);

        $connection = new AMQPStreamConnection('192.168.240.3', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('productsExport', false, false, false, false);

        $msg = new AMQPMessage($models->toJson());

        $channel->basic_publish($msg, '', 'productsExport');
        $channel->basic_publish($msg, '', 'productsExport');

        $channel->close();
        $connection->close();
    }
}
