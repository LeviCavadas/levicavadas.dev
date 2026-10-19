<?php

namespace MiniErp\Repositories;

use MiniErp\Core\Database;

class ProductRepository
{
    public function findBySku(string $sku): ?array
    {
        $statement = Database::connection()->prepare('SELECT * FROM products WHERE sku = :sku LIMIT 1');
        $statement->execute(['sku' => $sku]);
        $product = $statement->fetch();

        return $product ?: null;
    }
}
