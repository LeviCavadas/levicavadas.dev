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

if (!class_exists('MiniErp\\Database\\Seeds\\DevelopmentSeeder')) {
    require __DIR__ . '/../database/seeds/DevelopmentSeeder.php';
}

use MiniErp\Database\Seeds\DevelopmentSeeder;

Env::load(__DIR__ . '/..');
DevelopmentSeeder::run();

echo 'Development seed applied.' . PHP_EOL;
