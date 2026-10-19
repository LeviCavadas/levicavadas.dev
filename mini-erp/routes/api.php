<?php

use MiniErp\Core\App;
use MiniErp\Services\AuthService;
use MiniErp\Services\ClientService;
use MiniErp\Services\DashboardService;
use MiniErp\Services\ProductService;
use MiniErp\Services\SaleService;
use MiniErp\Services\UserService;
use MiniErp\Middleware\AuthMiddleware;
use MiniErp\Middleware\PermissionMiddleware;

return function (App $app) {
    $app->get('/api/v1/health', function ($request = [], $params = []) {
        return [
            'success' => true,
            'data' => [
                'status' => 'ok',
                'service' => 'mini-erp',
                'timestamp' => date('c'),
            ],
        ];
    });

    $app->post('/api/v1/auth/login', function ($request = [], $params = []) {
        $auth = new AuthService();
        return $auth->login($request);
    });

    $app->post('/api/v1/auth/logout', [AuthMiddleware::class, function ($request = [], $params = []) {
        return (new AuthService())->logout($request, $params);
    }]);

    $app->get('/api/v1/auth/me', [AuthMiddleware::class, function ($request = [], $params = []) {
        return (new AuthService())->me($request, $params);
    }]);

    $app->get('/api/v1/users', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager,operator', function ($request = [], $params = []) {
        return (new UserService())->listUsers();
    }]);

    $app->post('/api/v1/users', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager', function ($request = [], $params = []) {
        return (new UserService())->createUser($request);
    }]);

    $app->get('/api/v1/clients', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager,operator', function ($request = [], $params = []) {
        return (new ClientService())->listClients($request);
    }]);

    $app->post('/api/v1/clients', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager', function ($request = [], $params = []) {
        return (new ClientService())->createClient($request);
    }]);

    $app->get('/api/v1/products', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager,operator', function ($request = [], $params = []) {
        return (new ProductService())->listProducts($request);
    }]);

    $app->post('/api/v1/products', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager', function ($request = [], $params = []) {
        return (new ProductService())->createProduct($request);
    }]);

    $app->post('/api/v1/products/{id}/stock/movement', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager', function ($request = [], $params = []) {
        return (new ProductService())->registerStockMovement($request, (int) ($params['id'] ?? 0));
    }]);

    $app->get('/api/v1/dashboard/summary', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager,operator', function ($request = [], $params = []) {
        return (new DashboardService())->summary($request);
    }]);

    $app->get('/api/v1/sales', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager,operator', function ($request = [], $params = []) {
        return (new SaleService())->listSales($request);
    }]);

    $app->post('/api/v1/sales', [AuthMiddleware::class, PermissionMiddleware::class . ':admin,manager,operator', function ($request = [], $params = []) {
        return (new SaleService())->createSale($request);
    }]);
};
