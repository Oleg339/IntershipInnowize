<?php

namespace Api;

require_once('Controller/UserController.php');

use Controller;

class UserApi
{
    private $controller;

    public function __construct()
    {
        $this->controller = new Controller\UserController();
    }

    public function index()
    {
        $data = $this->convertToArray($this->controller->index());
        header('X-Pagination-Total: ' . sizeof($data));
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function store($request)
    {
        $data = $this->controller->store($request);
        if (is_array($data)) {
            http_response_code(422);
            echo json_encode(['messages' => $data]);

            return;
        }

        header('X-Pagination-Total: 1');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data->getValues());
    }

    public function delete($request, $id)
    {
        $response = $this->controller->delete($id);
        if (!$response) {
            http_response_code(404);
            echo json_encode(["message" => "Resource not found"]);
            
            return;
        }

        http_response_code(204);
    }

    private function convertToArray($users)
    {
        $data = [];

        foreach ($users as $user) {
            $data[] = $user->getValues();
        }

        return $data;
    }
}