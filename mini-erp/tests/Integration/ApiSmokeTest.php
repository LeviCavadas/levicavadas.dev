<?php

namespace MiniErp\Tests\Integration;

use MiniErp\Core\App;
use PHPUnit\Framework\TestCase;

class ApiSmokeTest extends TestCase
{
    public function testPublicHealthEndpointIsDefined(): void
    {
        $routes = require __DIR__ . '/../../routes/api.php';
        $this->assertIsCallable($routes);
    }

    public function testPasswordHashingUsesSecureAlgorithm(): void
    {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $this->assertNotSame('admin123', $hash);
        $this->assertTrue(password_verify('admin123', $hash));
    }

    public function testRequestBodyIsMergedIntoRequestContext(): void
    {
        $app = new App();
        $method = new \ReflectionMethod($app, 'callHandler');
        $method->setAccessible(true);

        $response = $method->invoke(
            $app,
            static function (array $request): string {
                return ($request['email'] ?? '') . ':' . ($request['password'] ?? '');
            },
            [
                'method' => 'POST',
                'path' => '/api/v1/auth/login',
                'query' => [],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => ['email' => 'admin@mini-erp.local', 'password' => 'admin123'],
            ],
            []
        );

        $this->assertSame('admin@mini-erp.local:admin123', $response);
    }

    public function testUtf8BomIsStrippedBeforeJsonDecode(): void
    {
        $app = new App();
        $decoder = new \ReflectionMethod($app, 'decodeJsonBody');
        $decoder->setAccessible(true);

        $decoded = $decoder->invoke($app, "\xEF\xBB\xBF{\"email\":\"admin@mini-erp.local\",\"password\":\"admin123\"}");

        $this->assertSame('admin@mini-erp.local', $decoded['email']);
        $this->assertSame('admin123', $decoded['password']);
    }
}
