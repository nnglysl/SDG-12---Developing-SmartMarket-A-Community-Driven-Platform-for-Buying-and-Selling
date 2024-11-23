-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 06:20 PM
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
-- Database: `smartmarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `condition` enum('new','like-new','lightly-used','heavily-used') DEFAULT 'new',
  `created_at` datetime DEFAULT current_timestamp(),
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `description`, `image_path`, `condition`, `created_at`, `stock`) VALUES
(1, 'CICS Department Shirt', 500.00, 'CICS Department Shirt Small - W:14 L:26 Medium - W:20 L:27 Large - W:21 L:28', '/final/imgs/department shirts/cics.png', 'new', '2024-11-22 13:55:25', 150),
(2, 'CAS Department Shirt', 500.00, 'CAS Department Shirt Small - W:14 L:26 Medium - W:20 L:27 Large - W:21 L:28', '/final/imgs/department shirts/cas.png', 'new', '2024-11-22 13:55:25', 150),
(3, 'CABE Department Shirt', 500.00, 'CABE Department Shirt Small - W:14 L:26 Medium - W:20 L:27 Large - W:21 L:28', '/final/imgs/department shirts/cabe.png', 'new', '0000-00-00 00:00:00', 150),
(4, 'Second Hand Casio Scientific Calculator', 500.00, 'Second Hand Scientific Calculator', '/final/imgs/school supplies/calcu.png', 'lightly-used', '2024-11-23 16:39:34', 1),
(5, 'ID Lace', 50.00, 'BSU ID Lace', '/final/imgs/school supplies/idlace.jpg', 'new', '2024-11-23 23:52:24', 200),
(6, 'University Collar Pin', 50.00, 'Size: 1inch', '/final/imgs/uniforms/collarpin.jfif', 'new', '2024-11-23 23:52:24', 80),
(7, 'B5 Binder Notebook', 70.00, '26 holes Product Size: B5(275*215mm) Number of Sheets: 60 Sheets', '/final/imgs/school supplies/binder.jpg', 'new', '2024-11-23 23:52:24', 3),
(8, 'Preloved PE Uniform Set', 400.00, 'Size: Small', '/final/imgs/uniforms/peunif.png', 'lightly-used', '2024-11-23 23:52:24', 1),
(9, 'Preloved College Blouse', 250.00, 'Size: Medium', '/final/imgs/uniforms/blouse.jpg', 'lightly-used', '2024-11-23 23:52:24', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `idx_product_name` (`product_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
