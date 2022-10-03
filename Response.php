<?php

class Response
{
    const CODES = [
        'OK' => 200,
        'CREATED' => 201,
        'NO_CONTENT' => 204,
        'BAD_REQUEST' => 400,
        'NOT_FOUND' => 404
    ];

    public static function notFound()
    {
        http_response_code(self::CODES['NOT_FOUND']);
        echo json_encode(['messages' => ['Resource not found']]);
    }

    public static function json($data, $code)
    {
        http_response_code(self::CODES[$code]);

        if (!$data) {
            return;
        }

        echo json_encode($data);
    }
}