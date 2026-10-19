<?php

namespace MiniErp\Services;

use MiniErp\Core\Database;
use MiniErp\Core\Response;

class ClientService
{
    public function listClients(array $request): void
    {
        $query = 'SELECT * FROM clients WHERE is_active = 1 ORDER BY created_at DESC';
        $statement = Database::connection()->query($query);
        Response::json(200, ['success' => true, 'data' => $statement->fetchAll()]);
    }

    public function createClient(array $request): void
    {
        $payload = $request['body'] ?? [];
        $name = trim((string) ($payload['name'] ?? ''));
        $email = isset($payload['email']) ? trim((string) $payload['email']) : null;

        if ($name === '') {
            Response::error(422, 'VALIDATION_ERROR', 'Client name is required.');
            return;
        }

        if ($email !== null && $email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Response::error(422, 'INVALID_EMAIL', 'The email format is invalid.');
            return;
        }

        $statement = Database::connection()->prepare(
            'INSERT INTO clients (name, email, phone, document, notes, is_active, created_at, updated_at) VALUES (:name, :email, :phone, :document, :notes, 1, NOW(), NOW())'
        );
        $statement->execute([
            'name' => $name,
            'email' => $email ?: null,
            'phone' => $payload['phone'] ?? null,
            'document' => $payload['document'] ?? null,
            'notes' => $payload['notes'] ?? null,
        ]);

        $id = (int) Database::connection()->lastInsertId();
        Response::json(201, ['success' => true, 'data' => ['id' => $id, 'name' => $name]]);
    }
}
