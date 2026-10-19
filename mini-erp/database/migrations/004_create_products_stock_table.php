<?php

return [
    'up' => <<<'SQL'
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(120) NOT NULL UNIQUE,
    name VARCHAR(180) NOT NULL,
    description TEXT NULL,
    category_id INT NULL,
    supplier_id INT NULL,
    sale_price DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    cost_price DECIMAL(12,2) NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    min_stock_quantity INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_by INT NULL,
    updated_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    CONSTRAINT fk_products_supplier FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL,
    CONSTRAINT fk_products_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_products_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_products_sku (sku),
    INDEX idx_products_category (category_id),
    INDEX idx_products_supplier (supplier_id),
    INDEX idx_products_stock (stock_quantity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS stock_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    type ENUM('in','out','adjustment') NOT NULL,
    quantity INT NOT NULL,
    quantity_before INT NOT NULL,
    quantity_after INT NOT NULL,
    reason VARCHAR(255) NOT NULL,
    reference_type VARCHAR(80) NULL,
    reference_id INT NULL,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_stock_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    CONSTRAINT fk_stock_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_stock_product_created (product_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
    'down' => <<<'SQL'
DROP TABLE IF EXISTS stock_movements;
DROP TABLE IF EXISTS products;
SQL,
];
