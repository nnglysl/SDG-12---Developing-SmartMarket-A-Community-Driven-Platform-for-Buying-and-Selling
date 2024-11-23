-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 06:53 PM
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
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `buyer_id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(11) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `password` varchar(150) NOT NULL,
  `confirm_password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`buyer_id`, `username`, `first_name`, `last_name`, `email`, `phone_number`, `gender`, `password`, `confirm_password`) VALUES
(1, 'Cocolughiuo', 'Colleen', 'Perez', 'coco@gmail.com', '09959141394', 'other', '$2y$10$WLfo/I3NZdFK74i6x.KIuuA2rzI7kbAUzFAzrvkiUHr3RirRmepJW', '$2y$10$dNPa27SH29IF0EcK5ni/0OmCu7i2g/IVsayyuzKyBt323kaaAAyDu'),
(2, 'coco', 'colleen', 'Perez', 'colleenperez05@gmail.com', NULL, NULL, '$2y$10$0HAQgewdwY.RzJ9XxZ60RuA45NNU.oz8m9xYPMJZnk60csyH43wG6', '$2y$10$sQjdcIl/0MtYTILNxraqbOM66.OFGnPI75/PjYo/PZKaMUAKGfcLe');

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

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_pasword` varchar(255) NOT NULL,
  `shop_name` varchar(150) NOT NULL,
  `buyer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `idx_product_name` (`product_name`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`seller_id`),
  ADD KEY `fk_buyer` (`buyer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `seller`
--
ALTER TABLE `seller`
  ADD CONSTRAINT `fk_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
