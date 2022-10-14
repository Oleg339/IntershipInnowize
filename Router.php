<?php

require_once 'vendor/autoload.php';

class Router
{
    private $get = [];
    private $post = [];
    private $delete = [];
    private $put = [];
    private $patch = [];

    public function get($route, $action): void
    {
        $this->get = array_merge($this->get, [$route => $action]);
    }

    public function post($route, $action): void
    {
        $this->post = array_merge($this->post, [$route => $action]);
    }

    public function delete($route, $action): void
    {
        $this->delete = array_merge($this->delete, [$route => $action]);
    }

    public function put($route, $action): void
    {
        $this->put = array_merge($this->put, [$route => $action]);
    }

    public function patch($route, $action): void
    {
        $this->patch = array_merge($this->patch, [$route => $action]);
    }

    public function run()
    {
        $request = new Request();
        $server = $_SERVER;
        $url = parse_url($server['REQUEST_URI'])['path'];

        if (strlen($url) != 1) {
            $url = rtrim($url, '/');
        }

        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $values = [];

        $route = $url;
        $urlArray = explode('/', $url);

        foreach ($urlArray as $item) {
            if (intval($item)) {
                $values[] = $item;
                $route = str_replace($item, '{id}', $url);
            }
        }

        if (array_key_exists($route, $this->$method)) {
            $value = $this->$method[$route];
            echo $value[0];
            $controller = new $value[0]();
            $action = $value[1];

            return $controller->$action($request, sizeof($values) == 1 ? $values[0] : $values);
        }

        http_response_code(404);
    }
}