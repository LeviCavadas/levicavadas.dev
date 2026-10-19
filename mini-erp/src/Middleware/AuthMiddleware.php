<?php

namespace MiniErp\Middleware;

use MiniErp\Core\Response;
use MiniErp\Core\Session;

class AuthMiddleware
{
    public function handle(array $request, array $roles = []): void
    {
        $user = Session::get('user');
        if (!is_array($user) || empty($user['id'])) {
            Response::error(401, 'UNAUTHENTICATED', 'Authentication is required.');
            exit;
        }

        if ($roles !== []) {
            $role = $user['role'] ?? 'operator';
            if (!in_array($role, $roles, true)) {
                Response::error(403, 'FORBIDDEN', 'Permission denied.');
                exit;
            }
        }
    }
}
