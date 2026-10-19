<?php

namespace MiniErp\Services;

use MiniErp\Core\Database;
use MiniErp\Core\Response;

class DashboardService
{
    public function summary(array $request): void
    {
        $pdo = Database::connection();
        $summary = [
            'sales_total' => (float) $pdo->query('SELECT COALESCE(SUM(total), 0) FROM sales WHERE status != "cancelled"')->fetchColumn(),
            'sales_count' => (int) $pdo->query('SELECT COUNT(*) FROM sales WHERE status != "cancelled"')->fetchColumn(),
            'clients_count' => (int) $pdo->query('SELECT COUNT(*) FROM clients WHERE is_active = 1')->fetchColumn(),
            'products_count' => (int) $pdo->query('SELECT COUNT(*) FROM products WHERE is_active = 1')->fetchColumn(),
            'low_stock_count' => (int) $pdo->query('SELECT COUNT(*) FROM products WHERE is_active = 1 AND stock_quantity <= min_stock_quantity')->fetchColumn(),
        ];

        Response::json(200, ['success' => true, 'data' => $summary]);
    }
}
