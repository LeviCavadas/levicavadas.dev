<?php

namespace MiniErp\Support;

class Logger
{
    public static function info(string $message, array $context = []): void
    {
        self::write('INFO', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::write('ERROR', $message, $context);
    }

    private static function write(string $level, string $message, array $context): void
    {
        $logDir = __DIR__ . '/../../storage/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $line = sprintf(
            '[%s] %s %s' . PHP_EOL,
            date('c'),
            $level,
            json_encode(['message' => $message, 'context' => $context], JSON_UNESCAPED_UNICODE)
        );

        file_put_contents($logDir . '/app.log', $line, FILE_APPEND | LOCK_EX);
    }
}
