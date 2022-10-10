<?php

namespace Controller;

include_once('AuthChecker.php');
include_once('FileValidator.php');
include_once('Logger.php');
include_once('TwigLoader.php');

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Task18\AuthChecker;
use Task18\FileValidator;
use Task18\Logger;
use Task18\TwigLoader;

class FileController
{
    const DIRECTORY = 'Uploads';

    public function index($request, $data = [])
    {
        $twig = TwigLoader::run();

        $user = AuthChecker::check($request);

        $files = [];

        $fileList = glob(self::DIRECTORY . '/' . $user->getValues()['email'] . '/*');

        foreach ($fileList as $filename) {
            if (is_file($filename)) {
                $files[] = end(@explode('/', $filename));
            }
        }

        echo $twig->render('Files.html', ['files' => $files, 'data' => $data]);
    }

    public function upload($request)
    {
        $user = AuthChecker::check($request);

        $logger = new Logger('logs/Task18_' . date_create()->format('dmY') . '.log');

        $file = $request->get()['file'];

        $directory = self::DIRECTORY . '/' . $user->getValues()['email'];

        $validator = new FileValidator($file, $directory);

        $name = $file['name'];
        $size = $file['size'];

        if (!file_exists($directory)) {
            @mkdir($directory, 0777, true);
            $logger->log('directory was created');
        }

        if (!$validator->validate()) {
            $logger->error(
                "File was not uploaded. Name: {name}, size {size}, reasons: {errors}",
                ['name' => $name, 'size' => $size . ' bytes', 'errors' => implode(', ', $validator->getErrors())]
            );

            return $this->index($request, ['errors' => $validator->getErrors()]);
        }

        $location = $directory;

        $fileLocation = $directory . '/' . $name;

        move_uploaded_file($file['tmp_name'], $fileLocation);

        $logger->log(
            "{name}-{size}bytes-{location}-{archiveSize}bytes",
            ['size' => strval($size), 'name' => $name, 'location' => $location, 'archiveSize' => strval($this->getDirectorySize($location))]
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