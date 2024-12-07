-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 09:01 PM
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
  `password` varchar(150) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `verification_code` int(11) NOT NULL,
  `verify` enum('not verified','verified') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`buyer_id`, `username`, `first_name`, `last_name`, `email`, `password`, `address`, `profile_picture`, `verification_code`, `verify`) VALUES
(1, 'asa', 'Colleen', 'Perez', 'coco@gmail.com', '$2y$10$WLfo/I3NZdFK74i6x.KIuuA2rzI7kbAUzFAzrvkiUHr3RirRmepJW', NULL, '', 0, 'not verified'),
(6, 'colleen_perez', 'Colleen', 'Perez', 'glyselannesales@gmail.com', 'colleenperez0781', 'Batangas', NULL, 0, 'verified'),
(7, 'rgo_official', 'Glysel', 'Sales', '23-32379@g.batstate-u.edu.ph', 'rgoofficial2304', 'Batangas', NULL, 0, 'verified'),
(12, 'coco3', 'colleen', 'Perez', 'rjcatapang12@gmail.com', '$2y$10$JwhQDTKIs8IYCgM..iXcC.PiVb6NodV0Ma3VnLgAGnyxOpMlOc49G', NULL, NULL, 3296, 'verified'),
(14, 'cocococo', 'colleen', 'Perez', '23-07395@g.batstate-u.edu.ph', '$2y$10$T0C2Agz5FjVNuG/zu3KXMue0Qekv1ZnhG.EhhnxbZ8xVLGyj4r0RK', NULL, '../uploads/674f11f689fb5_user.jpg', 7755, 'verified'),
(15, 'sadsadgfs', 'colleen', 'Perez', '23-38343@g.batstate-u.edu.ph', '$2y$10$6CvTgKyJp/2lC86vAKVU/.0pd7hYl.w/uN8ctns7pKpyeaA8UrQOC', NULL, '../uploads/674fb65bb1bb3_user.jpg', 2573, 'verified'),
(17, 'gly_sales', 'glysel', 'sales', '23-32379@g.batstate-u.edu.ph', '$2y$10$h/anqtlj4pWVHkfFfFWiJOqXxR1Vyy..mjQDT3z5vcvGkPZUpFqv6', NULL, '../uploads/675292f7c80b8_Back to school Instagram post Square.png', 6793, 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `cancelledorders`
--

CREATE TABLE `cancelledorders` (
  `cancel_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `item_picture` varchar(255) NOT NULL,
  `cancel_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_picture` varchar(255) NOT NULL,
  `size` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_name`, `price`, `quantity`, `product_picture`, `size`) VALUES
(24, 'Preloved College Blouse', 250.00, 1, '/final/imgs/uniforms/blouse.jpg', ''),
(25, 'CABE Department Shirt', 500.00, 1, '/final/imgs/department shirts/cas.png', ''),
(26, 'CABE Department Shirt', 500.00, 1, '/final/imgs/department shirts/cas.png', ''),
(27, 'CABE Department Shirt', 500.00, 1, '/final/imgs/department shirts/cas.png', ''),
(28, 'CABE Department Shirt', 500.00, 1, '/final/imgs/department shirts/cas.png', 'Large'),
(29, 'Second Hand Casio Scientific Calculator', 500.00, 1, '/final/imgs/school supplies/calcu.png', ''),
(30, 'Second Hand Casio Scientific Calculator', 500.00, 1, '/final/imgs/school supplies/calcu.png', ''),
(31, 'Preloved College Blouse', 250.00, 1, '/final/imgs/uniforms/blouse.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `submission_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courier`
--

CREATE TABLE `courier` (
  `courier_id` int(11) NOT NULL,
  `courier_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courier`
--

INSERT INTO `courier` (`courier_id`, `courier_name`, `email`, `password`) VALUES
(1, 'Courier1', 'courier1@gmail.com', '$2y$10$SGafvuhXRQC5DPyog38Hr.1MZ4AwxQwYPcvBLymqkXh7NdaTzA8LW');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `order_status` enum('to ship','cancel','to receive','delivered') NOT NULL DEFAULT 'to ship',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `item_picture` varchar(255) NOT NULL,
  `buyer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `item_name`, `quantity`, `item_price`, `order_status`, `created_at`, `item_picture`, `buyer_id`) VALUES
(11, 'CABE Department Shirt', 1, 500.00, 'to ship', '2024-12-04 14:29:02', '/final/imgs/department shirts/cabe.png', 15);

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
  `item_path` varchar(250) DEFAULT NULL,
  `seller_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `description`, `image_path`, `condition`, `created_at`, `item_path`, `seller_id`) VALUES
(1, 'CICS Department Shirt', 500.00, 'CICS Department Shirt Small - W:14 L:26 Medium - W:20 L:27 Large - W:21 L:28', '/final/imgs/department shirts/cics.png', 'new', '2024-11-22 13:55:25', '/final/items_deptshirt/cics/cics.php', 7),
(2, 'CAS Department Shirt', 500.00, 'CAS Department Shirt Small - W:14 L:26 Medium - W:20 L:27 Large - W:21 L:28', '/final/imgs/department shirts/cas.png', 'new', '2024-11-22 13:55:25', '/final/items_deptshirt/cas/cas.php', 7),
(3, 'CABE Department Shirt', 500.00, 'CABE Department Shirt Small - W:14 L:26 Medium - W:20 L:27 Large - W:21 L:28', '/final/imgs/department shirts/cabe.png', 'new', '0000-00-00 00:00:00', '/final/items_deptshirt/cabe/cabe.php', 7),
(4, 'Second Hand Casio Scientific Calculator', 500.00, 'Second Hand Scientific Calculator', '/final/imgs/school supplies/calcu.png', 'lightly-used', '2024-11-23 16:39:34', '/final/items/calcu/calcu.php', 6),
(5, 'ID Lace', 50.00, 'BSU ID Lace', '/final/imgs/school supplies/idlace.jpg', 'new', '2024-11-23 23:52:24', '/final/items/idlace/idlace.php', 7),
(6, 'University Collar Pin', 50.00, 'Size: 1inch', '/final/imgs/uniforms/collarpin.jfif', 'new', '2024-11-23 23:52:24', '/final/items_uniforms/collarpin/collarpin.php', 7),
(7, 'B5 Binder Notebook', 70.00, '26 holes Product Size: B5(275*215mm) Number of Sheets: 60 Sheets', '/final/imgs/school supplies/binder.jpg', 'new', '2024-11-23 23:52:24', '/final/items/binder/binder.php', 6),
(8, 'Preloved PE Uniform Set', 400.00, 'Size: Small', '/final/imgs/uniforms/peunif.png', 'lightly-used', '2024-11-23 23:52:24', '/final/items_uniforms/peunif/peunif.php', 6),
(9, 'Preloved College Blouse', 250.00, 'Size: Medium', '/final/imgs/uniforms/blouse.jpg', 'lightly-used', '2024-11-23 23:52:24', '/final/items_uniforms/blouse/blouse.php', 6);

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `variation_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variation_type` varchar(50) DEFAULT NULL,
  `variation_value` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`variation_id`, `product_id`, `variation_type`, `variation_value`, `price`, `stock`) VALUES
(1, 7, 'color', 'White', 70.00, 3),
(2, 7, 'color', 'Pink', 70.00, 2),
(3, 7, 'color', 'Clear', 70.00, 4),
(4, 1, 'size', 'Small', 500.00, 25),
(5, 1, 'size', 'Medium', 500.00, 100),
(6, 1, 'size', 'Large', 500.00, 50),
(7, 2, 'size', 'Small', 500.00, 40),
(8, 2, 'size', 'Medium', 500.00, 50),
(9, 2, 'size', 'Large', 500.00, 15),
(10, 3, 'size', 'Small', 500.00, 20),
(11, 3, 'size', 'Medium', 500.00, 50),
(12, 3, 'size', 'Large', 500.00, 30),
(13, 4, NULL, NULL, 500.00, 1),
(14, 5, NULL, NULL, 50.00, 200),
(15, 6, NULL, NULL, 50.00, 80),
(16, 8, NULL, NULL, 400.00, 1),
(17, 9, NULL, NULL, 250.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `shop_name` varchar(150) NOT NULL,
  `buyer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`seller_id`, `email`, `username`, `password`, `shop_name`, `buyer_id`) VALUES
(2, 'colleenperez05@gmail.com', '', '$2y$10$Pdt8Jfm1uBMZa5U5sfyxnuV4izOpNjVVtxy0TNboRR0esAbvvhGx2', 'coco', 1),
(3, 'colleenperez05@gmail.com', '', '$2y$10$jr.4QXMq0JjF9Mqg9Xb8ku4nxZ7vRAvIkBbh11XBfal2kmcsgUQha', 'coco', 1),
(4, '23-07395@g.batstate-u-edu.ph', 'Cocococ', '$2y$10$JCTzn9wPmS0wrw6ndBhjQ.ZHeg87g67wZt7dl0L7GntlBh05YGG2K', 'COCOCOCO', 14),
(5, '23-07395@g.batstate-u-edu.ph', 'azsdasdsa', '$2y$10$7FpgOTEha6ISYYHINXQhaez2togGm6Zm3yNpQJDMQoLITLX711gIG', 'dsadafdasad', 15),
(6, 'glyselannesales@gmail.com', 'colleen_perez', 'colleenperez0781', 'Colleen Perez', 6),
(7, '23-32379@g.batstate-u.edu.ph', 'rgo_official', 'rgoofficial2304', 'Resource Generation Office', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyer_id`);

--
-- Indexes for table `cancelledorders`
--
ALTER TABLE `cancelledorders`
  ADD PRIMARY KEY (`cancel_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`submission_id`);

--
-- Indexes for table `courier`
--
ALTER TABLE `courier`
  ADD PRIMARY KEY (`courier_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer` (`buyer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `idx_product_name` (`product_name`),
  ADD KEY `seller_id_fk` (`seller_id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`variation_id`),
  ADD KEY `product_id` (`product_id`);

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
  MODIFY `buyer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cancelledorders`
--
ALTER TABLE `cancelledorders`
  MODIFY `cancel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courier`
--
ALTER TABLE `courier`
  MODIFY `courier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `buyer` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `seller_id_fk` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`seller_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seller`
--
ALTER TABLE `seller`
  ADD CONSTRAINT `fk_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
