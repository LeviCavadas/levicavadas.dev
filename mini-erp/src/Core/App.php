<?php

namespace MiniErp\Core;

use RuntimeException;

class App
{
    private array $routes = [];
    private array $middlewares = [];

    public function __construct()
    {
        $this->loadRoutes();
    }

    public function get(string $pattern, callable|array $handler): void
    {
        $this->routes[] = ['GET', $pattern, $handler];
    }

    public function post(string $pattern, callable|array $handler): void
    {
        $this->routes[] = ['POST', $pattern, $handler];
    }

    public function patch(string $pattern, callable|array $handler): void
    {
        $this->routes[] = ['PATCH', $pattern, $handler];
    }

    public function put(string $pattern, callable|array $handler): void
    {
        $this->routes[] = ['PUT', $pattern, $handler];
    }

    public function delete(string $pattern, callable|array $handler): void
    {
        $this->routes[] = ['DELETE', $pattern, $handler];
    }

    public function run(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        foreach ($this->routes as [$routeMethod, $pattern, $handler]) {
            if ($routeMethod !== $method) {
                continue;
            }

            $params = $this->matchRoute($pattern, $requestUri);
            if ($params === null) {
                continue;
            }

            $payload = $this->parseJsonBody();
            $request = ['method' => $method, 'path' => $requestUri, 'query' => $_GET, 'body' => $payload, 'headers' => getallheaders() ?: []];
            if (is_array($payload) && $payload !== []) {
                $request = array_merge($payload, $request);
            }
            $result = $this->executeHandler($handler, $request, $params);
            return;
        }

        Response::error(404, 'ROUTE_NOT_FOUND', 'Route not found.');
    }

    private function matchRoute(string $pattern, string $uri): ?array
    {
        $pattern = preg_replace('#\{([^}]+)\}#', '([^/]+)', $pattern);
        $pattern = '#^' . str_replace('/', '\/', $pattern) . '$#';

        if (preg_match($pattern, $uri, $matches) !== 1) {
            return null;
        }

        preg_match_all('#\{([^}]+)\}#', $pattern, $names);
        $params = [];
        foreach ($matches as $index => $value) {
            if ($index === 0) {
                continue;
            }
            $params[] = $value;
        }

        return $params;
    }

    private function executeHandler(callable|array $handler, array $request, array $params): mixed
    {
        if (is_array($handler)) {
            $ordered = array_values($handler);
            $final = array_pop($ordered);
            $middlewares = $ordered;

            foreach ($middlewares as $middleware) {
                if (is_string($middleware)) {
                    $this->runMiddleware($middleware, $request);
                }
            }

            if (!is_callable($final)) {
                throw new RuntimeException('Invalid route handler');
            }
            return $this->callHandler($final, $request, $params);
        }

        return $this->callHandler($handler, $request, $params);
    }

    private function runMiddleware(string $middlewareName, array $request): void
    {
        $parts = explode(':', $middlewareName, 2);
        $class = $parts[0];
        $args = $parts[1] ?? '';
        $middleware = new $class();
        if (method_exists($middleware, 'handle')) {
            $middleware->handle($request, $args !== '' ? explode(',', $args) : []);
        }
    }

    private function callHandler(callable|array|string $handler, array $request, array $params): mixed
    {
        if (isset($request['body']) && is_array($request['body']) && $request['body'] !== []) {
            $request = array_merge($request['body'], $request);
        }

        if (is_string($handler)) {
            [$class, $method] = explode('::', $handler, 2);
            $classInstance = new $class();
            return $classInstance->$method($request, $params);
        }

        if (is_array($handler)) {
            [$controller, $method] = $handler;
            $controllerInstance = new $controller();
            return $controllerInstance->$method($request, $params);
        }

        $response = $handler($request, $params);
        if (is_array($response)) {
            $payload = $response;
            if (array_key_exists('success', $payload) || array_key_exists('error', $payload)) {
                Response::json(200, $payload);
                return null;
            }
            Response::json(200, ['success' => true, 'data' => $payload]);
            return null;
        }
        if ($response instanceof \Throwable) {
            throw $response;
        }
        return $response;
    }

    private function parseJsonBody(): array
    {
        $raw = file_get_contents('php://input');
        if ($raw === false || trim($raw) === '') {
            return [];
        }

        return $this->decodeJsonBody($raw);
    }

    private function decodeJsonBody(string $raw): array
    {
        $normalized = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
        $decoded = json_decode($normalized ?? $raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function loadRoutes(): void
    {
        $routeFile = __DIR__ . '/../../routes/api.php';
        if (file_exists($routeFile)) {
            $router = require $routeFile;
            if (is_callable($router)) {
                $router($this);
            }
        }
    }
}
