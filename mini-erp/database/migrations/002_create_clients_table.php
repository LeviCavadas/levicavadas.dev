<?php

return [
    'up' => <<<'SQL'
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(180) NOT NULL,
    email VARCHAR(180) NULL,
    phone VARCHAR(50) NULL,
    document VARCHAR(100) NULL,
    notes TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_by INT NULL,
    updated_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_clients_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_clients_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY uq_clients_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL,
    'down' => <<<'SQL'
DROP TABLE IF EXISTS clients;
SQL,
];
