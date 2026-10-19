<?php

namespace MiniErp\Repositories;

use MiniErp\Core\Database;

class ClientRepository
{
    public function listActive(): array
    {
        $statement = Database::connection()->query('SELECT * FROM clients WHERE is_active = 1 ORDER BY created_at DESC');
        return $statement->fetchAll();
    }
}
