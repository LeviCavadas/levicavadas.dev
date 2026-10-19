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
use MiniErp\Core\Database;

Env::load(__DIR__ . '/..');

$pdo = Database::connection();
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS schema_migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL UNIQUE,
        applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;'
);

$files = glob(__DIR__ . '/../database/migrations/*.php');
sort($files, SORT_NATURAL);

foreach ($files as $file) {
    $migrationName = basename($file);
    $applied = $pdo->prepare('SELECT COUNT(*) FROM schema_migrations WHERE migration = :migration');
    $applied->execute(['migration' => $migrationName]);
    if ((int) $applied->fetchColumn() > 0) {
        continue;
    }

    $sql = require $file;
    $pdo->exec($sql['up']);
    $pdo->prepare('INSERT INTO schema_migrations (migration) VALUES (:migration)')->execute(['migration' => $migrationName]);
    echo 'Applied: ' . $migrationName . PHP_EOL;
}

echo 'Migrations complete.' . PHP_EOL;
