<?php

class Validator
{
    private $file;

    private $directory;

    private $errors = [];

    const EXTENSIONS = ['png', 'img', 'txt', 'jpg'];

    public function __construct($file, $directory)
    {
        $this->file = $file;
        $this->directory = $directory;
    }

    public function validate()
    {
        if (!isset($name)) {
            $this->errors[] = 'File does not exists';
            return false;
        }

        $this->size();
        $this->extention();
        $this->isExists();

        if ($this->errors) {
            return false;
        }

        return true;
    }

    private function isExists()
    {
        if (file_exists($this->directory . '/' . $this->file['file']['name'])) {
            $this->errors[] = 'File already exists';

            return true;
        }

        return false;
    }

    private function size()
    {
        if ($this->file['file']['size'] > disk_free_space("C:")) {
            $this->errors[] = 'Size too big';

            return true;
        }

        return false;
    }

    private function extention()
    {
        if (!in_array(end(explode('.', $this->file['file']['name'])), self::EXTENSIONS)) {
            $this->errors[] = 'Invalid extention';

            return true;
        }

        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}