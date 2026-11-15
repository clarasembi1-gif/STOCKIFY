-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2026 at 05:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockify_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Electronics', 'Electronic devices and accessories', '2026-11-14 14:02:02'),
(2, 'Office Supplies', 'Office stationery and equipment', '2026-11-14 14:02:02'),
(3, 'Computer Accessories', 'Computer peripherals and accessories', '2026-11-14 14:02:02'),
(4, 'Furniture', 'Office and workspace furniture', '2026-11-14 14:02:02'),
(5, 'Networking', 'Networking equipment and devices', '2026-11-14 14:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `purchase_price` decimal(15,2) DEFAULT 0.00,
  `selling_price` decimal(15,2) DEFAULT 0.00,
  `stock_quantity` int(11) DEFAULT 0,
  `minimum_stock` int(11) DEFAULT 5,
  `unit` varchar(30) DEFAULT 'pcs',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `supplier_id`, `sku`, `name`, `description`, `purchase_price`, `selling_price`, `stock_quantity`, `minimum_stock`, `unit`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'STK-001', 'Wireless Headphone', 'Bluetooth wireless headphone', 250000.00, 350000.00, 45, 10, 'pcs', '2026-11-14 14:02:03', '2026-11-14 14:02:03'),
(2, 1, 1, 'STK-002', 'Mechanical Keyboard', 'Mechanical keyboard RGB', 400000.00, 550000.00, 28, 8, 'pcs', '2026-11-14 14:02:03', '2026-11-14 14:02:03'),
(3, 3, 3, 'STK-003', 'Wireless Mouse', 'Wireless optical mouse', 75000.00, 120000.00, 65, 15, 'pcs', '2026-11-14 14:02:03', '2026-11-14 14:02:03'),
(4, 3, 3, 'STK-004', 'USB Type-C Hub', 'Multiport USB Type-C hub', 150000.00, 220000.00, 13, 10, 'pcs', '2026-11-14 14:02:03', '2026-11-14 15:39:03'),
(5, 2, 2, 'STK-005', 'A4 Paper', 'A4 paper 80 GSM', 45000.00, 55000.00, 120, 20, 'ream', '2026-11-14 14:02:03', '2026-11-14 14:02:03'),
(6, 4, 2, 'STK-006', 'Office Chair', 'Ergonomic office chair', 750000.00, 950000.00, 12, 5, 'pcs', '2026-11-14 14:02:03', '2026-11-14 14:02:03'),
(7, 5, 4, 'STK-007', 'WiFi Router', 'Dual band wireless router', 300000.00, 425000.00, 25, 8, 'pcs', '2026-11-14 14:02:03', '2026-11-14 14:02:03'),
(8, 5, 4, 'STK-008', 'LAN Cable', 'Cat6 Ethernet cable', 50000.00, 85000.00, 2, 10, 'roll', '2026-11-14 14:02:03', '2026-11-14 15:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('in','out','adjustment') NOT NULL,
  `quantity` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `product_id`, `user_id`, `type`, `quantity`, `notes`, `created_at`) VALUES
(1, 1, NULL, 'in', 45, 'Initial stock', '2026-11-14 14:02:03'),
(2, 2, NULL, 'in', 28, 'Initial stock', '2026-11-14 14:02:03'),
(3, 3, NULL, 'in', 65, 'Initial stock', '2026-11-14 14:02:03'),
(4, 4, NULL, 'in', 8, 'Initial stock', '2026-11-14 14:02:03'),
(5, 5, NULL, 'in', 120, 'Initial stock', '2026-11-14 14:02:03'),
(6, 6, NULL, 'in', 12, 'Initial stock', '2026-11-14 14:02:03'),
(7, 7, NULL, 'in', 25, 'Initial stock', '2026-11-14 14:02:03'),
(8, 8, NULL, 'in', 5, 'Initial stock', '2026-11-14 14:02:03'),
(9, 4, NULL, 'in', 5, 'Testing Stock In', '2026-11-14 15:39:03'),
(10, 8, NULL, 'out', 3, 'Testing Stock Out.', '2026-11-14 15:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_person`, `phone`, `email`, `address`, `created_at`) VALUES
(1, 'Techno Supply', 'Andi Pratama', '081234567890', 'techno@example.com', 'Jakarta', '2026-11-14 14:02:03'),
(2, 'Global Office', 'Budi Santoso', '081298765432', 'global@example.com', 'Bandung', '2026-11-14 14:02:03'),
(3, 'Digital Hardware', 'Rizky Saputra', '085678901234', 'digital@example.com', 'Medan', '2026-11-14 14:02:03'),
(4, 'Smart Network', 'Dimas Putra', '082112223333', 'smart@example.com', 'Surabaya', '2026-11-14 14:02:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin@stockify.com', '$2y$10$oXq5KpGinncFxH/H3D4blecyCcH2Qn0eHVLyG3S2LVjxGHu3gc.yu', 'admin', '2026-11-14 16:34:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `fk_product_supplier` (`supplier_id`),
  ADD KEY `idx_product_name` (`name`),
  ADD KEY `idx_product_category` (`category_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movement_user` (`user_id`),
  ADD KEY `idx_movement_product` (`product_id`),
  ADD KEY `idx_movement_date` (`created_at`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `fk_movement_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_movement_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
