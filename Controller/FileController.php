<?php

namespace Controller;

include_once("Validator.php");
include_once("Logger/Logger.php");



use Logger;
use Validator;

class FileController
{
    const DIRECTORY = 'uploads';

    public function index($data = [], $twig = '')
    {
        require_once 'bootstrap.php';

        $files = [];

        $fileList = glob(self::DIRECTORY . '/*');

        foreach ($fileList as $filename) {
            if (is_file($filename)) {
                $files[] = end(@explode('/', $filename));
            }
        }


        echo $twig->render('Files.html', ['files' => $files, 'data' => $data]);
    }

    public function upload($request)
    {
        require_once 'bootstrap.php';

        $logger = new Logger('logs/upload_' . date_create()->format('dmY') . '.log');
        $file = $request->get()['file'];

        $validator = new Validator($file, self::DIRECTORY);

        $name = $file['name'];
        $size = $file['size'];

        if (!file_exists(self::DIRECTORY)) {
            $logger->error('directory does not exists');
            @mkdir(self::DIRECTORY);
        }

        $location = self::DIRECTORY . '/' . $name;

        if (!$validator->validate()) {
            $logger->error(
                "File was not uploaded. Name: {name}, size {size}, reasons: {errors}",
                ['name' => $name, 'size' => $size . ' bytes', 'errors' => implode(', ', $validator->getErrors())]
            );

            return $this->index(['errors' => $validator->getErrors()], $twig);;
        }

        move_uploaded_file($file['tmp_name'], $location);

        $logger->log(
            "File was uploaded successfully. name: {name}, size: {size}",
            ['size' => $size . ' bytes', 'name' => $name]
        );

        $this->index(['size' => $size, 'name' => $name, 'meta' => getimagesize($location)], $twig);
    }
}


