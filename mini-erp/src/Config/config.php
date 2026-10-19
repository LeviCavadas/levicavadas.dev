<?php
return [
    'app' => [
        'name' => 'Mini ERP',
        'env' => getenv('APP_ENV') ?: 'local',
        'url' => getenv('APP_URL') ?: 'http://localhost:8000',
    ],
    'database' => [
        'driver' => getenv('DB_DRIVER') ?: getenv('DB_CONNECTION') ?: 'mysql',
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'database' => getenv('DB_NAME') ?: 'mini_erp',
        'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
        'username' => getenv('DB_USER') ?: 'mini_erp_user',
        'password' => getenv('DB_PASSWORD') ?: 'change_me',
        'name' => getenv('DB_NAME') ?: 'mini_erp',
        'user' => getenv('DB_USER') ?: 'mini_erp_user',
    ],
    'session' => [
        'name' => getenv('SESSION_NAME') ?: 'mini_erp_session',
        'lifetime' => (int) (getenv('SESSION_LIFETIME') ?: '1800'),
        'idle_timeout' => (int) (getenv('SESSION_IDLE_TIMEOUT') ?: (getenv('SESSION_LIFETIME') ?: '1800')),
        'secure' => filter_var(getenv('SESSION_SECURE_COOKIE') ?: 'false', FILTER_VALIDATE_BOOLEAN),
        'same_site' => getenv('SESSION_SAME_SITE') ?: 'Lax',
    ],
];
