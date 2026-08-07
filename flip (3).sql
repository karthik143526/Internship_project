-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2026 at 09:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flip`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'teja', 'karthikvenkat062@gmail.com', '$2y$10$mWLOGA4i38k5EvdqatkMO.jg9sNo062xO1gC.6pSCLuU6MS/yZNfG', '2025-09-15 16:42:44'),
(2, 'admin', 'admin@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXh0oE8Vt56sK4oGzhPBOoTphjz2F6a', '2025-09-15 16:47:21'),
(3, 'sai', 'hello1234@gmail.com', '$2y$10$vt9GAbTDV1Q7XvrYRf9t7uPxbokQ9EGpAs49GDF48UML3XE25nNk6', '2025-09-15 17:08:46'),
(4, 'dharma', 'dharma12@gmail.com', '$2y$10$/dSSzRIDfEtypCmLW8L0nuEJGzAaEBuno//GPX6c4HeXk70Cgt5NW', '2025-09-18 08:28:35'),
(5, 'sai', 'sai12345@gmail.com', '$2y$10$WmBaSqBUJAvDLfCgl0giQ.zTaxE5UiqFGIMhyCaIBV.JkIL.B.AMW', '2026-03-03 03:09:04');

-- --------------------------------------------------------

--
-- Table structure for table `admin_credentials`
--

CREATE TABLE `admin_credentials` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `admin_id` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_credentials`
--

INSERT INTO `admin_credentials` (`id`, `email`, `admin_id`, `created_at`) VALUES
(1, 'karthikvenkat062@gmail.com', '192372092', '2026-05-08 04:17:16');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_email`, `phone_number`, `product_name`, `product_price`, `payment_method`, `address`, `order_date`) VALUES
(13, 'venkatakarthikkokkiligadda@gmail.com', '8008444328', 'Laptop', 45999.00, 'Cash on Delivery', 'Thanda Lam Chennai', '2025-09-20 15:47:07'),
(14, 'venkatakarthikkokkiligadda@gmail.com', '8008444328', 'Washing Machine', 24999.00, 'Cash on Delivery', 'SIMATS,Thandlam', '2026-02-13 21:18:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(6, 'chari', 'chari12@gmail.com', '$2y$10$ZugfYOwQnQL8FmiyzfQ9F.mrraJKSP4Umo7/Oc5No5aIaXTr..pr6', '2026-02-13 15:48:05'),
(7, 'karthik', 'karthikvenkat062@gmail.com', '$2y$10$u5wtmmX14xgQyx..wh8pCOwx/pm1pKJeERnU4oUbcNGhHYdBlFDKq', '2026-02-13 15:54:11'),
(8, 'karthik', 'hello12345@gmail.com', '$2y$10$6TOp9PI5KYwfoh2RZCs7NOl3Gz8pIrNLDg0vY036uCcMO7QsJp7Qe', '2026-03-03 03:07:10'),
(9, 'navaneeth', 'navaneeth123@gmail.com', '$2y$10$Va/Rm49HIVLUCd3fDka.4ufDvy7O.Bo9g1F.LM/2iYXDviiE0kbIa', '2026-04-28 03:43:53'),
(10, 'dathu', 'dathu1234@gmail.com', '$2y$10$y4HmGXRfQY7mLUzQC0BDfOL6wKTPVOaDUf/b1mDY1v.djbcBkN7EG', '2026-05-08 06:53:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `admin_id` (`admin_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
