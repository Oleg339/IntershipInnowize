<?php

namespace Task13;

use Controller\UserController;
use Api\UserApi;

include_once('Controller/UserController.php');
include_once('Request.php');
include_once('Api/UserApi.php');

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

    public function run(): void
    {
        $request = new Request();
        $server = $request->getSERVER();
        $url = parse_url($server['REQUEST_URI'])['path'];
        
        if (str_ends_with($url, '/')) {
            $url = substr($url, 0, -1);
        }

        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $value = '';

        $route = $url;
        $urlArray = explode('/', $url);

        if (array_key_exists(2, $urlArray) && intval($urlArray[2])) {
            $value = $urlArray[2];
            $route = str_replace($value, '{id}', $url);
        }

        if (array_key_exists($route, $this->$method)) {
            $controller = new $this->$method[$route][0]();
            $action = $this->$method[$route][1];
            $controller->$action($request, $value);
            return;
        }
        http_response_code(404);
    }
}
