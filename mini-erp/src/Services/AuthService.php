<?php

namespace MiniErp\Services;

use MiniErp\Core\Database;
use MiniErp\Core\Response;
use MiniErp\Core\Session;
use MiniErp\Support\Helpers;

class AuthService
{
    public function login(array $request): void
    {
        $email = Helpers::normalizeEmail((string) ($request['email'] ?? ''));
        $password = (string) ($request['password'] ?? '');

        if ($email === '' || $password === '') {
            Response::error(422, 'VALIDATION_ERROR', 'Email and password are required.');
            return;
        }

        $statement = Database::connection()->prepare('SELECT * FROM users WHERE email = :email AND is_active = 1 LIMIT 1');
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            Response::error(401, 'INVALID_CREDENTIALS', 'Invalid credentials.');
            return;
        }

        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            Database::connection()->prepare('UPDATE users SET password_hash = :hash WHERE id = :id')->execute([
                'hash' => password_hash($password, PASSWORD_DEFAULT),
                'id' => $user['id'],
            ]);
        }

        Session::set('user', [
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'is_active' => (bool) $user['is_active'],
        ]);

        Response::json(200, [
            'success' => true,
            'data' => [
                'user' => [
                    'id' => (int) $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                ],
            ],
        ]);
    }

    public function logout(array $request, array $app): void
    {
        Session::destroy();
        Response::json(200, ['success' => true, 'data' => ['logged_out' => true]]);
    }

    public function me(array $request, array $app): void
    {
        $user = Session::get('user');

        if (!is_array($user) || empty($user['id'])) {
            Response::error(401, 'UNAUTHENTICATED', 'Authentication required.');
            return;
        }

        Response::json(200, ['success' => true, 'data' => ['user' => $user]]);
    }
}
