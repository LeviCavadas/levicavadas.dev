<?php

namespace MiniErp\Core;

class Response
{
    public static function json(int $status, array $payload): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public static function error(int $status, string $code, string $message, array $details = []): void
    {
        self::json($status, [
            'success' => false,
            'error' => [
                'code' => $code,
                'message' => $message,
                'details' => $details,
            ],
        ]);
    }
}
