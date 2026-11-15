-- ==========================================
-- STOCKIFY INVENTORY MANAGEMENT SYSTEM
-- Database Schema
-- ==========================================

CREATE DATABASE IF NOT EXISTS stockify_db;

USE stockify_db;

-- ==========================================
-- 1. TABLE USERS
-- ==========================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ==========================================
-- 2. TABLE CATEGORIES
-- ==========================================

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ==========================================
-- 3. TABLE SUPPLIERS
-- ==========================================

CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    contact_person VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ==========================================
-- 4. TABLE PRODUCTS
-- ==========================================

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    supplier_id INT DEFAULT NULL,
    sku VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    purchase_price DECIMAL(15,2) DEFAULT 0,
    selling_price DECIMAL(15,2) DEFAULT 0,
    stock_quantity INT DEFAULT 0,
    minimum_stock INT DEFAULT 5,
    unit VARCHAR(30) DEFAULT 'pcs',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_product_category
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_product_supplier
        FOREIGN KEY (supplier_id)
        REFERENCES suppliers(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;


-- ==========================================
-- 5. TABLE STOCK MOVEMENTS
-- ==========================================

CREATE TABLE stock_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT DEFAULT NULL,
    type ENUM('in', 'out', 'adjustment') NOT NULL,
    quantity INT NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_movement_product
        FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_movement_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;


-- ==========================================
-- INDEXES
-- ==========================================

CREATE INDEX idx_product_name
ON products(name);

CREATE INDEX idx_product_category
ON products(category_id);

CREATE INDEX idx_movement_product
ON stock_movements(product_id);

CREATE INDEX idx_movement_date
ON stock_movements(created_at);


-- ==========================================
-- DUMMY DATA: CATEGORIES
-- ==========================================

INSERT INTO categories (id, name, description) VALUES
(1, 'Electronics', 'Electronic devices and accessories'),
(2, 'Office Supplies', 'Office stationery and equipment'),
(3, 'Computer Accessories', 'Computer peripherals and accessories'),
(4, 'Furniture', 'Office and workspace furniture'),
(5, 'Networking', 'Networking equipment and devices');


-- ==========================================
-- DUMMY DATA: SUPPLIERS
-- ==========================================

INSERT INTO suppliers
(id, name, contact_person, phone, email, address)
VALUES
(1, 'Techno Supply', 'Andi Pratama', '081234567890',
 'techno@example.com', 'Jakarta'),

(2, 'Global Office', 'Budi Santoso', '081298765432',
 'global@example.com', 'Bandung'),

(3, 'Digital Hardware', 'Rizky Saputra', '085678901234',
 'digital@example.com', 'Medan'),

(4, 'Smart Network', 'Dimas Putra', '082112223333',
 'smart@example.com', 'Surabaya');


-- ==========================================
-- DUMMY DATA: PRODUCTS
-- ==========================================

INSERT INTO products
(id, category_id, supplier_id, sku, name,
 description, purchase_price, selling_price,
 stock_quantity, minimum_stock, unit)
VALUES

(1, 1, 1, 'STK-001', 'Wireless Headphone',
 'Bluetooth wireless headphone',
 250000, 350000, 45, 10, 'pcs'),

(2, 1, 1, 'STK-002', 'Mechanical Keyboard',
 'Mechanical keyboard RGB',
 400000, 550000, 28, 8, 'pcs'),

(3, 3, 3, 'STK-003', 'Wireless Mouse',
 'Wireless optical mouse',
 75000, 120000, 65, 15, 'pcs'),

(4, 3, 3, 'STK-004', 'USB Type-C Hub',
 'Multiport USB Type-C hub',
 150000, 220000, 8, 10, 'pcs'),

(5, 2, 2, 'STK-005', 'A4 Paper',
 'A4 paper 80 GSM',
 45000, 55000, 120, 20, 'ream'),

(6, 4, 2, 'STK-006', 'Office Chair',
 'Ergonomic office chair',
 750000, 950000, 12, 5, 'pcs'),

(7, 5, 4, 'STK-007', 'WiFi Router',
 'Dual band wireless router',
 300000, 425000, 25, 8, 'pcs'),

(8, 5, 4, 'STK-008', 'LAN Cable',
 'Cat6 Ethernet cable',
 50000, 85000, 5, 10, 'roll');


-- ==========================================
-- DUMMY DATA: INITIAL STOCK MOVEMENTS
-- ==========================================

INSERT INTO stock_movements
(product_id, user_id, type, quantity, notes)
VALUES

(1, NULL, 'in', 45, 'Initial stock'),
(2, NULL, 'in', 28, 'Initial stock'),
(3, NULL, 'in', 65, 'Initial stock'),
(4, NULL, 'in', 8, 'Initial stock'),
(5, NULL, 'in', 120, 'Initial stock'),
(6, NULL, 'in', 12, 'Initial stock'),
(7, NULL, 'in', 25, 'Initial stock'),
(8, NULL, 'in', 5, 'Initial stock');


-- ==========================================
-- END OF STOCKIFY DATABASE
-- ==========================================