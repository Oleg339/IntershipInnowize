<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Mail\Attachment;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ExportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function export()
    {
        $connection = new AMQPStreamConnection('192.168.240.1', 5672, 'guest', 'guest');

        $channel = $connection->channel();

        $channel->queue_declare('productsExport', false, false, false, false);

        $callback = function ($data) {
            if (!File::exists(public_path() . "/files")) {
                File::makeDirectory(public_path() . "/files");
            }

            $data = json_decode($data->body, true);

            $filename = public_path('files/products.csv');
            $handle = fopen($filename, 'w');

            fputcsv($handle, ['id', 'type', 'company', 'name', 'cost', 'release_date']);
            $values = [];

            foreach ($data as $models) {
                foreach ($models as $model) {
                    $values[] = $model;
                }

                fputcsv($handle, $values);

                $values = [];
            }

            fclose($handle);

            Storage::disk('s3')->put('user-uploads.csv', File::get($filename));

            Mail::send('emails.products', [], function ($message) use ($data) {
                $message->to($data[array_key_last($data)]['email'])->subject('Products');
                $message->attach(Attachment::fromPath("files/products.csv"));
            });
        };

        $channel->basic_consume('productsExport', '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
