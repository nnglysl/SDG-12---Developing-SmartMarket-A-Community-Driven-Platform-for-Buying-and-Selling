-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 11:02 AM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
