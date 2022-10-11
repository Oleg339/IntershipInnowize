<?php

namespace Controller;

include_once('AuthChecker.php');
include_once('Validator.php');
include_once('Logger.php');
include_once('TwigLoader.php');

use FilesystemIterator;
use Psr\Log\LogLevel;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Task18\AuthChecker;
use Task18\Validator;
use Task18\Logger;
use Task18\TwigLoader;

class FileController
{
    const DIRECTORY = 'Uploads';

    public function index($request, $data = [])
    {
        $twig = TwigLoader::run();

        $email = AuthChecker::getUserEmail($request->getSession());

        $files = [];

        $fileList = glob(self::DIRECTORY . '/' . $email . '/*');

        foreach ($fileList as $filename) {
            if (is_file($filename)) {
                $files[] = end(@explode('/', $filename));
            }
        }

        echo $twig->render('Files.html', ['files' => $files, 'data' => $data]);
    }

    public function upload($request)
    {
        $email = AuthChecker::getUserEmail($request->getSession());

        $logger = new Logger('logs/Task18_' . date_create()->format('dmY') . '.log');

        $directory = self::DIRECTORY . '/' . $email;

        if (!file_exists($directory)) {
            @mkdir($directory, 0777, true);
            $logger->log(LogLevel::NOTICE, 'directory was created');
        }

        $file = $request->get()['file'];
        $name = $file['name'];
        $size = $file['size'];

        $validator = new Validator(['file' => $file, 'directory' => $directory]);

        $isValidated = $validator->validate(['file' => ['isExists', 'isUploaded', 'extension']]);

        if (!$isValidated) {
            $logger->log(
                LogLevel::ERROR,
                "File was not uploaded. Name: {name}, size {size}, reasons: {errors}",
                ['name' => $name, 'size' => $size . ' bytes', 'errors' => implode(', ', $validator->getErrors())]
            );

            return $this->index($request, ['errors' => $validator->getErrors()]);
        }

        if ($file['size'] > 10000000) {
            $logger->log(
                LogLevel::ERROR,
                "File size too big: {name}, {size}",
                ['name' => $name, 'size' => $size
                ]);

            return $this->index($request, ['errors' => ['File size too big']]);
        }

        $fileLocation = $directory . '/' . $name;

        move_uploaded_file($file['tmp_name'], $fileLocation);

        $logger->log(
            LogLevel::INFO,
            "{name}-{size}bytes-{location}-{archiveSize}bytes",
            ['size' => strval($size), 'name' => $name, 'location' => $directory, 'archiveSize' => strval($this->getDirectorySize($directory))]
        );

        $this->index($request, ['size' => $size, 'name' => $name, 'meta' => getimagesize($fileLocation)]);
    }

    function getDirectorySize($path)
    {
        $bytestotal = 0;
        $path = realpath($path);

        if ($path !== false && $path != '' && file_exists($path)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $bytestotal += $object->getSize();
            }
        }

        return $bytestotal;
    }
}