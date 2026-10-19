<?php

namespace MiniErp\Services;

use MiniErp\Core\Database;
use MiniErp\Core\Response;
use MiniErp\Core\Session;

class SaleService
{
    public function listSales(array $request): void
    {
        $statement = Database::connection()->query('SELECT * FROM sales ORDER BY created_at DESC LIMIT 100');
        Response::json(200, ['success' => true, 'data' => $statement->fetchAll()]);
    }

    public function createSale(array $request): void
    {
        $payload = $request['body'] ?? [];
        $clientId = isset($payload['client_id']) && $payload['client_id'] !== '' ? (int) $payload['client_id'] : null;
        $items = $payload['items'] ?? [];
        $discountType = strtolower((string) ($payload['discount_type'] ?? 'none'));
        $discountValue = (float) ($payload['discount_value'] ?? 0);

        if (!is_array($items) || count($items) === 0) {
            Response::error(422, 'VALIDATION_ERROR', 'At least one sale item is required.');
            return;
        }

        $pdo = Database::connection();
        $pdo->beginTransaction();

        try {
            $subtotal = 0.0;
            $productData = [];

            foreach ($items as $item) {
                $productId = (int) ($item['product_id'] ?? 0);
                $quantity = (int) ($item['quantity'] ?? 0);

                if ($productId <= 0 || $quantity <= 0) {
                    throw new \RuntimeException('Each sale item must include a valid product and a positive quantity.');
                }

                $productStmt = $pdo->prepare('SELECT id, name, sale_price, stock_quantity, is_active FROM products WHERE id = :id FOR UPDATE');
                $productStmt->execute(['id' => $productId]);
                $product = $productStmt->fetch();

                if (!$product || (int) $product['is_active'] !== 1) {
                    throw new \RuntimeException('The selected product does not exist or is inactive.');
                }

                if ((int) $product['stock_quantity'] < $quantity) {
                    throw new \RuntimeException('Insufficient stock for product: ' . $product['name']);
                }

                $lineTotal = (float) $product['sale_price'] * $quantity;
                $subtotal += $lineTotal;
                $productData[] = [
                    'id' => $productId,
                    'name' => $product['name'],
                    'unit_price' => (float) $product['sale_price'],
                    'quantity' => $quantity,
                    'line_total' => $lineTotal,
                ];
            }

            $discountAmount = 0.0;
            if ($discountType === 'percentage') {
                $discountAmount = min($subtotal * ($discountValue / 100), $subtotal);
            } elseif ($discountType === 'fixed') {
                $discountAmount = min((float) $discountValue, $subtotal);
            }

            $total = max($subtotal - $discountAmount, 0.0);

            $user = Session::get('user');
            $createdBy = $user['id'] ?? 1;

            $saleStmt = $pdo->prepare(
                'INSERT INTO sales (sale_number, client_id, status, subtotal, discount_type, discount_value, discount_amount, total, notes, created_by, created_at, updated_at) VALUES (:sale_number, :client_id, :status, :subtotal, :discount_type, :discount_value, :discount_amount, :total, :notes, :created_by, NOW(), NOW())'
            );
            $saleNumber = 'SALE-' . date('YmdHis') . '-' . random_int(1000, 9999);
            $saleStmt->execute([
                'sale_number' => $saleNumber,
                'client_id' => $clientId,
                'status' => 'confirmed',
                'subtotal' => $subtotal,
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'discount_amount' => $discountAmount,
                'total' => $total,
                'notes' => $payload['notes'] ?? null,
                'created_by' => $createdBy,
            ]);
            $saleId = (int) $pdo->lastInsertId();

            foreach ($productData as $item) {
                $itemStmt = $pdo->prepare(
                    'INSERT INTO sale_items (sale_id, product_id, product_name_snapshot, unit_price, quantity, line_subtotal, created_at) VALUES (:sale_id, :product_id, :product_name_snapshot, :unit_price, :quantity, :line_subtotal, NOW())'
                );
                $itemStmt->execute([
                    'sale_id' => $saleId,
                    'product_id' => $item['id'],
                    'product_name_snapshot' => $item['name'],
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'line_subtotal' => $item['line_total'],
                ]);

                $pdo->prepare('UPDATE products SET stock_quantity = stock_quantity - :qty, updated_at = NOW() WHERE id = :id')->execute([
                    'qty' => $item['quantity'],
                    'id' => $item['id'],
                ]);

                $pdo->prepare(
                    'INSERT INTO stock_movements (product_id, type, quantity, quantity_before, quantity_after, reason, reference_type, reference_id, created_by, created_at) VALUES (:product_id, :type, :quantity, :quantity_before, :quantity_after, :reason, :reference_type, :reference_id, :created_by, NOW())'
                )->execute([
                    'product_id' => $item['id'],
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'quantity_before' => 0,
                    'quantity_after' => 0,
                    'reason' => 'sale',
                    'reference_type' => 'sale',
                    'reference_id' => $saleId,
                    'created_by' => $createdBy,
                ]);
            }

            $pdo->commit();

            Response::json(201, ['success' => true, 'data' => ['sale_id' => $saleId, 'sale_number' => $saleNumber, 'total' => round($total, 2)]]);
        } catch (\Throwable $thrown) {
            $pdo->rollBack();
            Response::error(422, 'SALE_CREATION_FAILED', $thrown->getMessage());
        }
    }
}
