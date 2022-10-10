<?php

namespace Task18;

class Request
{
    private $server;
    private $post;
    private $get;
    private $session;
    private $cookie;

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->post = $_POST;
        $this->get = $_GET;
        $this->session = $_SESSION;
        $this->cookie = $_COOKIE;
    }

    public function get()
    {
        parse_str(file_get_contents("php://input"), $INPUT);

        return array_merge($this->get, $this->post, $_FILES, $INPUT, $_SESSION, $_COOKIE, $_SERVER);
    }

    public function getCookie()
    {
        return $this->cookie;
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

    public function getSession()
    {
        return $this->session;
    }
}