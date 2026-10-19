<?php

namespace MiniErp\Config;

class Env
{
    public static function load(string $path): void
    {
        $file = $path . '/.env';
        if (!is_file($file)) {
            return;
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || str_starts_with($trimmed, '#')) {
                continue;
            }

            [$key, $value] = array_pad(explode('=', $trimmed, 2), 2, '');
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if ($key !== '') {
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
                putenv($key . '=' . $value);
            }
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        if ($value === false || $value === null) {
            return $default;
        }

        return $value;
    }
}
