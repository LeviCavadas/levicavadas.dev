<?php

namespace MiniErp\Services;

use MiniErp\Core\Database;
use MiniErp\Core\Response;

class ProductService
{
    public function listProducts(array $request): void
    {
        $statement = Database::connection()->query('SELECT * FROM products WHERE is_active = 1 ORDER BY created_at DESC');
        Response::json(200, ['success' => true, 'data' => $statement->fetchAll()]);
    }

    public function createProduct(array $request): void
    {
        $payload = $request['body'] ?? [];
        $sku = trim((string) ($payload['sku'] ?? ''));
        $name = trim((string) ($payload['name'] ?? ''));
        $salePrice = (float) ($payload['sale_price'] ?? 0);
        $stock = (int) ($payload['stock_quantity'] ?? 0);

        if ($sku === '' || $name === '') {
            Response::error(422, 'VALIDATION_ERROR', 'SKU and name are required.');
            return;
        }

        if ($salePrice < 0 || $stock < 0) {
            Response::error(422, 'INVALID_VALUE', 'Price and stock quantity must be greater than or equal to zero.');
            return;
        }

        $existing = Database::connection()->prepare('SELECT id FROM products WHERE sku = :sku LIMIT 1');
        $existing->execute(['sku' => $sku]);
        if ($existing->fetch()) {
            Response::error(409, 'SKU_ALREADY_EXISTS', 'This product sku is already in use.');
            return;
        }

        $statement = Database::connection()->prepare(
            'INSERT INTO products (sku, name, description, category_id, supplier_id, sale_price, cost_price, stock_quantity, min_stock_quantity, is_active, created_at, updated_at) VALUES (:sku, :name, :description, :category_id, :supplier_id, :sale_price, :cost_price, :stock_quantity, :min_stock_quantity, 1, NOW(), NOW())'
        );
        $statement->execute([
            'sku' => $sku,
            'name' => $name,
            'description' => $payload['description'] ?? null,
            'category_id' => $payload['category_id'] ?? null,
            'supplier_id' => $payload['supplier_id'] ?? null,
            'sale_price' => $salePrice,
            'cost_price' => $payload['cost_price'] ?? null,
            'stock_quantity' => $stock,
            'min_stock_quantity' => $payload['min_stock_quantity'] ?? 0,
        ]);

        $id = (int) Database::connection()->lastInsertId();
        Response::json(201, ['success' => true, 'data' => ['id' => $id, 'sku' => $sku, 'name' => $name]]);
    }

    public function registerStockMovement(array $request, int $productId): void
    {
        $payload = $request['body'] ?? [];
        $type = strtolower((string) ($payload['type'] ?? ''));
        $quantity = (int) ($payload['quantity'] ?? 0);
        $reason = trim((string) ($payload['reason'] ?? ''));

        if (!in_array($type, ['in', 'out', 'adjustment'], true) || $quantity <= 0 || $reason === '') {
            Response::error(422, 'VALIDATION_ERROR', 'Type, quantity and reason are required for stock changes.');
            return;
        }

        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $product = $pdo->prepare('SELECT stock_quantity FROM products WHERE id = :id FOR UPDATE');
            $product->execute(['id' => $productId]);
            $current = $product->fetch();

            if (!$current) {
                throw new \RuntimeException('Product not found.');
            }

            $before = (int) $current['stock_quantity'];
            $after = $before;
            if ($type === 'in') {
                $after = $before + $quantity;
            } elseif ($type === 'out') {
                $after = $before - $quantity;
                if ($after < 0) {
                    throw new \RuntimeException('Stock quantity cannot be negative.');
                }
            } else {
                $after = $quantity;
            }

            $pdo->prepare('UPDATE products SET stock_quantity = :stock, updated_at = NOW() WHERE id = :id')->execute([
                'stock' => $after,
                'id' => $productId,
            ]);

            $pdo->prepare(
                'INSERT INTO stock_movements (product_id, type, quantity, quantity_before, quantity_after, reason, created_at) VALUES (:product_id, :type, :quantity, :quantity_before, :quantity_after, :reason, NOW())'
            )->execute([
                'product_id' => $productId,
                'type' => $type,
                'quantity' => $quantity,
                'quantity_before' => $before,
                'quantity_after' => $after,
                'reason' => $reason,
            ]);

            $pdo->commit();
            Response::json(201, ['success' => true, 'data' => ['product_id' => $productId, 'stock_after' => $after]]);
        } catch (\Throwable $thrown) {
            $pdo->rollBack();
            Response::error(400, 'STOCK_MOVEMENT_FAILED', $thrown->getMessage());
        }
    }
}
