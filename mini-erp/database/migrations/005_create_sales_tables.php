<?php

return [
    'up' => <<<'SQL'
CREATE TABLE IF NOT EXISTS sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_number VARCHAR(80) NOT NULL UNIQUE,
    client_id INT NULL,
    status ENUM('draft','confirmed','cancelled') NOT NULL DEFAULT 'draft',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    discount_type ENUM('none','percentage','fixed') NOT NULL DEFAULT 'none',
    discount_value DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    discount_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    notes TEXT NULL,
    created_by INT NULL,
    cancelled_at TIMESTAMP NULL,
    cancelled_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_sales_client FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL,
    CONSTRAINT fk_sales_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_sales_cancelled_by FOREIGN KEY (cancelled_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_sales_client (client_id),
    INDEX idx_sales_status (status),
    INDEX idx_sales_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sale_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name_snapshot VARCHAR(180) NOT NULL,
    unit_price DECIMAL(12,2) NOT NULL,
    quantity INT NOT NULL,
    line_subtotal DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_sale_items_sale FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    CONSTRAINT fk_sale_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    method ENUM('cash','pix','credit_card','debit_card','bank_transfer','other') NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    status ENUM('pending','paid','refunded') NOT NULL DEFAULT 'pending',
    paid_at TIMESTAMP NULL,
    reference VARCHAR(255) NULL,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_payments_sale FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    CONSTRAINT fk_payments_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
    'down' => <<<'SQL'
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS sale_items;
DROP TABLE IF EXISTS sales;
SQL,
];
