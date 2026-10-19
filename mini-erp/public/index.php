<?php

$autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoload)) {
    require $autoload;
} else {
    spl_autoload_register(function (string $class): void {
        $prefix = 'MiniErp\\';
        if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
            return;
        }

        $relative = substr($class, strlen($prefix));
        $path = __DIR__ . '/../src/' . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($path)) {
            require $path;
        }
    });
}

use MiniErp\Config\Env;
use MiniErp\Core\App;
use MiniErp\Core\Response;
use MiniErp\Core\Session;

Env::load(__DIR__ . '/..');
Session::start();

try {
    $app = new App();
    $app->run();
} catch (\Throwable $throwable) {
    Response::error(500, 'INTERNAL_SERVER_ERROR', 'A server error occurred.', [
        'debug' => Env::get('APP_DEBUG', 'false') === 'true',
        'message' => Env::get('APP_DEBUG', 'false') === 'true' ? $throwable->getMessage() : 'Application in production mode.',
    ]);
}
