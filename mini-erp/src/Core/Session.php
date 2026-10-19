<?php

namespace MiniErp\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $config = require __DIR__ . '/../Config/config.php';
            session_name($config['session']['name']);
            ini_set('session.gc_maxlifetime', (string) $config['session']['idle_timeout']);
            session_set_cookie_params([
                'lifetime' => $config['session']['idle_timeout'],
                'path' => '/',
                'httponly' => true,
                'secure' => $config['session']['secure'],
                'samesite' => $config['session']['same_site'],
            ]);
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function forget(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }
}
