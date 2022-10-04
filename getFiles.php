<?php

$files = [];

$fileList = glob('uploads/*');

foreach ($fileList as $filename) {
    if (is_file($filename)) {
        $files[] = end(explode('/', $filename));
    }
}

echo json_encode($files);