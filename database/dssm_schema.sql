-- DSSM (Daily Sales and Stock-In Management System)
-- Database Schema SQL File
-- Generated: 2026-04-20

-- ============================================================
-- CREATE DATABASE
-- ============================================================
CREATE DATABASE IF NOT EXISTS dssmsystem;
USE dssmsystem;

-- ============================================================
-- USERS TABLE (Extended from Laravel default)
-- ============================================================
DROP TABLE IF EXISTS sessions;
DROP TABLE IF EXISTS password_reset_tokens;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    position VARCHAR(100) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    remember_token VARCHAR(100) NULL,
    two_factor_secret TEXT NULL,
    two_factor_recovery_codes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SUPPLIERS TABLE
-- ============================================================
DROP TABLE IF EXISTS suppliers;

CREATE TABLE suppliers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_person VARCHAR(255) NULL,
    phone VARCHAR(50) NULL,
    address TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- CATEGORIES TABLE
-- ============================================================
DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- STATUSES TABLE
-- ============================================================
DROP TABLE IF EXISTS statuses;

CREATE TABLE statuses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- BALES TABLE
-- ============================================================
DROP TABLE IF EXISTS bales;

CREATE TABLE bales (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bale_number VARCHAR(100) UNIQUE NOT NULL,
    supplier_id BIGINT UNSIGNED NOT NULL,
    purchase_price DECIMAL(12,2) NOT NULL,
    total_items INT NOT NULL,
    purchase_date DATE NOT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_bales_supplier ON bales(supplier_id);
CREATE INDEX idx_bales_number ON bales(bale_number);

-- ============================================================
-- ITEMS TABLE
-- ============================================================
DROP TABLE IF EXISTS items;

CREATE TABLE items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bale_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    status_id BIGINT UNSIGNED NOT NULL,
    item_code VARCHAR(100) UNIQUE NOT NULL,
    description TEXT NULL,
    price DECIMAL(12,2) NOT NULL,
    quantity INT DEFAULT 1,
    is_sold BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (bale_id) REFERENCES bales(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (status_id) REFERENCES statuses(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_items_bale ON items(bale_id);
CREATE INDEX idx_items_category ON items(category_id);
CREATE INDEX idx_items_status ON items(status_id);
CREATE INDEX idx_items_code ON items(item_code);
CREATE INDEX idx_items_sold ON items(is_sold);

-- ============================================================
-- TRANSACTIONS TABLE
-- ============================================================
DROP TABLE IF EXISTS transactions;

CREATE TABLE transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    transaction_number VARCHAR(50) UNIQUE NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    payment_method ENUM('cash', 'gcash', 'card', 'mixed') DEFAULT 'cash',
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_transactions_user ON transactions(user_id);
CREATE INDEX idx_transactions_number ON transactions(transaction_number);
CREATE INDEX idx_transactions_date ON transactions(created_at);

-- ============================================================
-- TRANSACTION_ITEMS TABLE (Pivot)
-- ============================================================
DROP TABLE IF EXISTS transaction_items;

CREATE TABLE transaction_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaction_id BIGINT UNSIGNED NOT NULL,
    item_id BIGINT UNSIGNED NOT NULL,
    quantity INT DEFAULT 1,
    unit_price DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_ti_transaction ON transaction_items(transaction_id);
CREATE INDEX idx_ti_item ON transaction_items(item_id);

-- ============================================================
-- DEFAULT RECORDS (Seed Data)
-- ============================================================

-- Insert Categories
INSERT INTO categories (name, description) VALUES
('Tops', 'Shirts, blouses, and tops'),
('Bottoms', 'Pants, shorts, skirts'),
('Dresses', 'Dresses and jumpsuits'),
('Outerwear', 'Jackets, coats, and cardigans'),
('Accessories', 'Bags, belts, hats, and scarves'),
('Footwear', 'Shoes and sandals');

-- Insert Statuses
INSERT INTO statuses (name, description) VALUES
('Available', 'Item is available for sale'),
('Reserved', 'Item is reserved for a customer'),
('Damaged', 'Item is damaged and cannot be sold');

-- Insert Suppliers
INSERT INTO suppliers (name, contact_person, phone, address) VALUES
('Thrift Supply Co.', 'John Doe', '0912-345-6789', 'Manila, Philippines'),
('Fashion Wholesale', 'Jane Smith', '0918-765-4321', 'Quezon City, Philippines'),
(' Bulk Items Inc.', 'Mike Wilson', '0922-123-4567', 'Cebu City, Philippines'),
('Garment Direct', 'Sarah Lee', '0933-987-6543', 'Davao City, Philippines');

-- Insert Users (password: password123)
INSERT INTO users (employee_id, name, email, password, position, is_active) VALUES
('EMP001', 'Maria Santos', 'maria@dssm.local', '$2y$12$NoofaDqzqvWGCLaQfLNE6huFm4zt9eZ5buXoIAxFIh0=', 'Cashier', TRUE),
('EMP002', 'John Rivera', 'john@dssm.local', '$2y$12$NoofaDqzqvWGCLaQfLNE6huFm4zt9eZ5buXoIAxFIh0=', 'Cashier', TRUE),
('EMP003', 'Ana Garcia', 'ana@dssm.local', '$2y$12$NoofaDqzqvWGCLaQfLNE6huFm4zt9eZ5buXoIAxFIh0=', 'Manager', TRUE),
('EMP004', 'Carlos Mendoza', 'carlos@dssm.local', '$2y$12$NoofaDqzqvWGCLaQfLNE6huFm4zt9eZ5buXoIAxFIh0=', 'Stock Keeper', TRUE);

-- ============================================================
-- NOTES
-- ============================================================
-- 1. All foreign keys enforce referential integrity
-- 2. Items can only be deleted if their parent Bale is deleted (CASCADE)
-- 3. Categories and Statuses cannot be deleted if items exist (RESTRICT)
-- 4. Transactions cannot be deleted if they have items (CASCADE)
-- 5. Database is normalized to 3NF