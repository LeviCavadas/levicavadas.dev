<?php

namespace MiniErp\Repositories;

use MiniErp\Core\Database;

class UserRepository
{
    public function findByEmail(string $email): ?array
    {
        $statement = Database::connection()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        return $user ?: null;
    }
}
