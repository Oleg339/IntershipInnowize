<?php

namespace App\Export;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Export
{
    /**
     * @throws \Exception
     */
    public static function export()
    {
        $connection = new AMQPStreamConnection('172.25.0.2', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
//            echo ' ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| [x] Received ', $msg->body, "\n";
            if (!File::exists(public_path() . "/files")) {
                File::makeDirectory(public_path() . "/files");
            }

            $filename = public_path("files/products.csv");

            $handle = fopen($filename, 'w');

            $fields = Schema::getColumnListing('products');

            fputcsv($handle, $fields);
            $values = [];

//        foreach ($models as $model) {
//            foreach ($fields as $field) {
//                $values[] = $model->$field;
//            }
//
//            fputcsv($handle, $values);
//
//            $values = [];
//        }

            fclose($handle);

            $a = Storage::disk('s3')->put('products.csv', File::get($filename));
        };

        $channel->basic_consume('hello', '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
