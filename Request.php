<?php

namespace Task16;

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
        parse_str(file_get_contents("php://input"), $post_vars);

        return array_merge($this->get, $this->post, $_FILES, $post_vars);
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