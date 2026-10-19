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

if ($argc < 4) {
    echo "Usage: php scripts/create-admin.php <name> <email> <password>\n";
    exit(1);
}

$name = $argv[1];
$email = strtolower(trim($argv[2]));
$password = $argv[3];

$pdo = Database::connection();
$statement = $pdo->prepare('INSERT INTO users (name, email, password_hash, role, is_active, created_at, updated_at) VALUES (:name, :email, :password_hash, :role, 1, NOW(), NOW()) ON DUPLICATE KEY UPDATE name = VALUES(name), password_hash = VALUES(password_hash), role = VALUES(role)');
$statement->execute([
    'name' => $name,
    'email' => $email,
    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    'role' => 'admin',
]);

echo 'Admin user created or updated successfully.' . PHP_EOL;
