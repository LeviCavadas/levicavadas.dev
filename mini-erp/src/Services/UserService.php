<?php

namespace MiniErp\Services;

use MiniErp\Core\Database;
use MiniErp\Core\Response;
use MiniErp\Core\Session;
use MiniErp\Support\Helpers;

class UserService
{
    public function listUsers(): void
    {
        $statement = Database::connection()->query('SELECT id, name, email, role, is_active, last_login_at, created_at FROM users ORDER BY created_at DESC');
        Response::json(200, ['success' => true, 'data' => $statement->fetchAll()]);
    }

    public function createUser(array $request): void
    {
        $payload = $request['body'] ?? [];
        $name = trim((string) ($payload['name'] ?? ''));
        $email = Helpers::normalizeEmail((string) ($payload['email'] ?? ''));
        $password = (string) ($payload['password'] ?? '');
        $role = (string) ($payload['role'] ?? 'operator');

        if ($name === '' || $email === '' || $password === '') {
            Response::error(422, 'VALIDATION_ERROR', 'Name, email and password are required.');
            return;
        }

        if (!in_array($role, ['admin', 'manager', 'operator', 'consult'], true)) {
            Response::error(422, 'INVALID_ROLE', 'The selected role is not supported.');
            return;
        }

        $existing = Database::connection()->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $existing->execute(['email' => $email]);
        if ($existing->fetch()) {
            Response::error(409, 'EMAIL_ALREADY_EXISTS', 'This email address is already in use.');
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $statement = Database::connection()->prepare(
            'INSERT INTO users (name, email, password_hash, role, is_active, created_at, updated_at) VALUES (:name, :email, :password_hash, :role, 1, NOW(), NOW())'
        );
        $statement->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $hash,
            'role' => $role,
        ]);

        $id = (int) Database::connection()->lastInsertId();
        Response::json(201, ['success' => true, 'data' => ['id' => $id, 'name' => $name, 'email' => $email, 'role' => $role]]);
    }
}
