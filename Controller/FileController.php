<?php

namespace Controller;

include_once("../Response.php");
include_once("../Validator.php");
include_once("../Logger/Logger.php");

use Logger;
use Response;
use Validator;

class fileController
{
    public function upload()
    {
        $response = new Response();
        $directory = '../uploads';
        $fileName = $_FILES['file']['name'];
        $logger = new Logger('../logs/upload_' . date_create()->format('dmY') . '.log');

        if (!isset($fileName)) {
            $logger->critical('file does not exists');
            return $response->addData(['messages' => 'file does not exists'])->send();
        }

        if (!file_exists($directory)) {
            $logger->error('directory does not exists');
            @mkdir($directory);
        }

        $validator = new Validator($_FILES, $directory);
        $location = $directory . '/' . $fileName;

        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];

        if (!$validator->validate()) {
            $logger->error(
                "File was not uploaded. Name: {name}, size {size}, reasons: {errors}",
                ['name' => $name, 'size' => $size . ' bytes', 'errors' => implode(', ', $validator->getErrors())]
            );

            return $response->addData(["messages" => $validator->getErrors()])->send();
        }

        move_uploaded_file($_FILES['file']['tmp_name'], $location);

        $logger->log(
            "File was uploaded successfully. name: {name}, size: {size}",
            ['size' => $size . ' bytes', 'name' => $name]
        );

        return $response
            ->addData(["size" => $size])
            ->addData(["name" => $name])
            ->addData(["meta" => getimagesize($location)])
            ->send();
    }
}


$controller = new fileController();
$controller->upload();

