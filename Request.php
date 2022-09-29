<?php

namespace Task13;

class Request
{
    private $server;
    private $post;
    private $get;

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->post = $_POST;
        $this->get = $_GET;
    }

    public function get()
    {
        return array_merge($this->get, $this->post);
    }

    public function getServer(): array
    {
        return $this->server;
    }

    public function getPost(): array
    {
        return $this->post;
    }

    public function getGet(): array
    {
        return $this->get;
    }
}