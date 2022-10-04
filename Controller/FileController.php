<?php

namespace Controller;

include_once("../Response.php");
include_once("../Validator.php");
include_once("../Logger/Logger.php");

use Logger;
use Response;
use Validator;

class FileController
{

    const DIRECTORY = '../uploads';

    public function upload()
    {
        $response = new Response();
        $logger = new Logger('../logs/upload_' . date_create()->format('dmY') . '.log');
        $validator = new Validator($_FILES, self::DIRECTORY);
        $name = $_FILES['file']['name'];

        if (!file_exists(self::DIRECTORY)) {
            $logger->error('directory does not exists');
            @mkdir(self::DIRECTORY);
        }

        $location = self::DIRECTORY . '/' . $name;

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


$controller = new FileController();
$controller->upload();

