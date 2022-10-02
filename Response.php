<?php

class Response
{
    public static function notFound()
    {
        http_response_code(404);
        echo json_encode(['messages' => ['Resource not found']]);
    }

    public static function validationError($errors)
    {
        http_response_code(400);
        echo json_encode(['messages' => $errors]);
    }

    public static function sendData($data)
    {
        http_response_code(201);
        echo json_encode($data);
    }

    public static function success()
    {
        http_response_code(204);
    }
}