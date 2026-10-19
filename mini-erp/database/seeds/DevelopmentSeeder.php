<?php

namespace MiniErp\Database\Seeds;

use MiniErp\Core\Database;

class DevelopmentSeeder
{
    public static function run(): void
    {
        $pdo = Database::connection();

        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->prepare(
            'INSERT INTO users (name, email, password_hash, role, is_active, created_at, updated_at) VALUES (:name, :email, :password_hash, :role, 1, NOW(), NOW()) ON DUPLICATE KEY UPDATE email = email'
        )->execute([
            'name' => 'Administrador',
            'email' => 'admin@mini-erp.local',
            'password_hash' => $password,
            'role' => 'admin',
        ]);

        $pdo->prepare(
            'INSERT INTO clients (name, email, phone, document, notes, is_active, created_at, updated_at) VALUES (:name, :email, :phone, :document, :notes, 1, NOW(), NOW()) ON DUPLICATE KEY UPDATE name = name'
        )->execute([
            'name' => 'Ana Souza',
            'email' => 'ana@demo.local',
            'phone' => '(11) 90000-0001',
            'document' => '12345678900',
            'notes' => 'Cliente de demonstração.',
        ]);

        $pdo->prepare(
            'INSERT INTO categories (name, description, is_active, created_at, updated_at) VALUES (:name, :description, 1, NOW(), NOW()) ON DUPLICATE KEY UPDATE name=name'
        )->execute([
            'name' => 'Material de Escritório',
            'description' => 'Materiais e itens de escritório.',
        ]);

        $pdo->prepare(
            'INSERT INTO suppliers (name, email, phone, document, notes, is_active, created_at, updated_at) VALUES (:name, :email, :phone, :document, :notes, 1, NOW(), NOW()) ON DUPLICATE KEY UPDATE name=name'
        )->execute([
            'name' => 'Fornecedor Demo',
            'email' => 'fornecedor@demo.local',
            'phone' => '(11) 90000-0002',
            'document' => '98765432100',
            'notes' => 'Fornecedor fictício de demonstração.',
        ]);

        $pdo->prepare(
            'INSERT INTO products (sku, name, description, category_id, supplier_id, sale_price, cost_price, stock_quantity, min_stock_quantity, is_active, created_at, updated_at) VALUES (:sku, :name, :description, :category_id, :supplier_id, :sale_price, :cost_price, :stock_quantity, :min_stock_quantity, 1, NOW(), NOW()) ON DUPLICATE KEY UPDATE sku=sku'
        )->execute([
            'sku' => 'MAT-001',
            'name' => 'Caderno Premium',
            'description' => 'Caderno com capa reforçada.',
            'category_id' => 1,
            'supplier_id' => 1,
            'sale_price' => 24.90,
            'cost_price' => 12.50,
            'stock_quantity' => 25,
            'min_stock_quantity' => 8,
        ]);
    }
}
