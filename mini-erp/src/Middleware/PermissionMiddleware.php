<?php

namespace MiniErp\Middleware;

use MiniErp\Core\Response;
use MiniErp\Core\Session;

class PermissionMiddleware
{
    public function handle(array $request, array $allowed = []): void
    {
        $user = Session::get('user');
        $role = $user['role'] ?? 'operator';

        if ($allowed === []) {
            return;
        }

        if (!in_array($role, $allowed, true)) {
            Response::error(403, 'FORBIDDEN', 'You do not have permission to access this resource.');
            exit;
        }
    }
}
