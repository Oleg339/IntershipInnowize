<?php

namespace Task13;

class Request
{
    private $SERVER;
    private $POST;
    private $GET;

    public function __construct()
    {
        $this->SERVER = $_SERVER;
        $this->POST = $_POST;
        $this->GET = $_GET;
    }

    public function get()
    {
        return array_merge($this->GET, $this->POST);
    }

    public function getSERVER(): array
    {
        return $this->SERVER;
    }

    public function getPOST(): array
    {
        return $this->POST;
    }

    public function getGET(): array
    {
        return $this->GET;
    }
}