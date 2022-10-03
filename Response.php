<?php

class Response
{
    public static function notFound()
    {
        http_response_code(404);
        echo json_encode(['messages' => ['Resource not found']]);
    }

    public static function json($data, $code)
    {
        http_response_code($code);

        if (!$data) {
            return;
        }

        echo json_encode($data);
    }
}