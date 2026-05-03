-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 05:43 PM
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
-- Database: `cozybite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `full_name`, `email`, `created_at`) VALUES
(2, 'cozybite', '$2y$10$4vhzDaxsb705mwj2LFJ5TO/kbqzH01HLt9BuwgX7J5TG3eAjpxP7G', 'Cozybite', 'cozybite@gmail.com', '2026-04-25 08:54:45');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_name` varchar(150) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_orders`
--

CREATE TABLE `custom_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `cake_type` varchar(100) DEFAULT NULL,
  `flavour` varchar(100) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `delivery_person_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `advance_amount` decimal(10,2) DEFAULT NULL,
  `remaining_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_orders`
--

INSERT INTO `custom_orders` (`id`, `user_id`, `name`, `phone`, `email`, `address`, `cake_type`, `flavour`, `size`, `message`, `image`, `request_date`, `status`, `delivery_person_id`, `price`, `payment_method`, `payment_status`, `advance_amount`, `remaining_amount`) VALUES
(4, 1, 'Rajvi Patel', '1234567890', 'rp@gmail.com', 'raj residency', 'ganach', 'chocolate', '2', 'happy birthday', NULL, '2026-04-27 17:14:04', 'Delivered', 2, 2000.00, NULL, 'paid', 1000.00, 0.00),
(5, 1, 'Rajvi Patel', '09512351064', 'rajvipatel2612@gmail.com', '17,Raj residency ,Shilaj,', 'ganach', 'caramel', '2.5', 'happy aniversery', NULL, '2026-04-28 07:21:08', 'Completed', 2, 2000.00, NULL, 'paid', 1000.00, 0.00),
(6, 1, 'Rajvi Patel', '09512351064', 'rajvipatel2612@gmail.com', '17,Raj residency ,Shilaj,', 'cream', 'red velvet', '3', 'happy aniversery', NULL, '2026-04-28 07:35:35', 'Completed', 2, 3000.00, NULL, 'paid', 1500.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_persons`
--

CREATE TABLE `delivery_persons` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `current_lat` decimal(10,7) DEFAULT NULL,
  `current_lng` decimal(10,7) DEFAULT NULL,
  `last_seen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_persons`
--

INSERT INTO `delivery_persons` (`id`, `name`, `email`, `phone`, `photo`, `is_active`, `current_lat`, `current_lng`, `last_seen`, `created_at`, `address`, `password`) VALUES
(2, 'mukesh', 'mukesh@gmail.com', '1234567890', '1777108427_OIP.jpeg', 1, 23.0650142, 72.4396039, '2026-05-01 05:28:45', '2026-04-25 09:13:47', 'Gota, Ahmedabad', '123');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 'Your custom order #1 is Completed!', 1, '2026-04-25 12:01:44'),
(2, 1, 'Your custom order #1 is Completed!', 1, '2026-04-25 12:16:20'),
(3, 1, 'Your custom order #2 is Completed!', 1, '2026-04-27 17:09:25'),
(4, 1, 'Your custom order #3 is Completed!', 1, '2026-04-27 17:12:34'),
(5, 1, 'Your custom order #4 is Completed!', 1, '2026-04-27 17:15:26'),
(6, 1, 'Your custom order #5 is Completed!', 1, '2026-04-28 07:22:31'),
(7, 1, 'Your custom order #5 is Completed!', 1, '2026-04-28 07:34:13'),
(8, 1, 'Your custom order #6 is Completed!', 1, '2026-04-28 07:36:07'),
(9, 1, 'Your custom order #6 is Completed!', 1, '2026-04-28 08:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `delivery_person_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `order_date`, `status`, `address`, `delivery_person_id`) VALUES
(1, 1, 80.00, '2026-04-25 05:32:19', 'Delivered', 'Padmavali, shilaj ', 2),
(2, 1, 80.00, '2026-04-25 08:04:42', 'Paid', 'Raj , Shilaj', NULL),
(3, 1, 360.00, '2026-04-25 08:18:35', 'Delivered', 'skyenclave , bhadaj, ahmedabad', 2),
(4, 1, 100.00, '2026-04-25 08:38:21', 'Delivered', 'raj residency', 2),
(5, 1, 199.00, '2026-04-26 01:56:01', 'Pending', 'raj residency shilaj', NULL),
(6, 1, 199.00, '2026-04-26 03:50:24', 'Out for Delivery', 'raj residency shilaj', 2),
(7, 1, 380.00, '2026-04-27 13:32:16', 'Delivered', 'Raj residency', 2),
(8, 1, 200.00, '2026-04-27 13:34:27', 'Delivered', 'raj residency', 2),
(9, 1, 690.00, '2026-05-01 01:56:33', 'Out for Delivery', '17,Raj residency ,Shilaj,', 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(150) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `price`, `quantity`) VALUES
(1, 1, 'chocolate cupcake', 80.00, 1),
(2, 2, 'chocolate cupcake', 80.00, 1),
(3, 3, 'chocolate cupcake', 80.00, 2),
(4, 3, 'chocolate cookie', 100.00, 1),
(5, 3, 'kunafabar', 100.00, 1),
(6, 4, 'chocolate cookie', 100.00, 1),
(7, 5, 'Weekend Offer Cake', 199.00, 1),
(8, 6, 'Weekend Offer Cupcake', 199.00, 1),
(9, 7, 'chocolate cupcake', 80.00, 1),
(10, 7, 'chocolate cookie', 100.00, 1),
(11, 7, 'biscoff cheesecake', 200.00, 1),
(12, 8, 'walnut brownie', 200.00, 1),
(13, 9, 'chocolate cupcake', 80.00, 3),
(14, 9, 'almond waffle ', 150.00, 1),
(15, 9, 'kunafabar', 100.00, 2),
(16, 9, 'chocolate cookie', 100.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `payment_status`, `amount`, `payment_date`, `order_type`) VALUES
(1, 1, 'COD', 'Pending', 80.00, '2026-04-25 09:02:24', 'normal'),
(2, 2, 'UPI', 'Paid', 80.00, '2026-04-25 11:34:46', 'normal'),
(3, 3, 'COD', 'Pending', 360.00, '2026-04-25 11:48:42', 'normal'),
(4, 1, 'Online', 'Advance Paid', 475.00, '2026-04-25 11:59:38', 'custom'),
(5, 4, 'COD', 'Pending', 100.00, '2026-04-25 12:08:24', 'normal'),
(6, 5, 'COD', 'Pending', 199.00, '2026-04-26 05:26:07', 'normal'),
(7, 6, 'UPI', 'Paid', 199.00, '2026-04-26 07:20:29', 'normal'),
(8, 7, 'UPI', 'Paid', 380.00, '2026-04-27 17:02:18', 'normal'),
(9, 8, 'COD', 'Pending', 200.00, '2026-04-27 17:04:29', 'normal'),
(10, 2, 'Online', 'Advance Paid', 1500.00, '2026-04-27 17:09:03', 'custom'),
(11, 5, 'Online', 'Advance Paid', 1000.00, '2026-04-28 07:21:36', 'custom'),
(12, 6, 'Online', 'Advance Paid', 1500.00, '2026-04-28 07:35:52', 'custom'),
(13, 9, 'COD', 'Pending', 690.00, '2026-05-01 05:26:41', 'normal');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `category`) VALUES
(1, 'chocolate cupcake', NULL, 80.00, NULL, 'chocolate_cupcake.jpeg', '2026-04-25 08:58:59', 'cupcakes'),
(2, 'kunafabar', NULL, 100.00, NULL, 'kunafa_chocolate.jpeg', '2026-04-25 11:41:58', 'chocolate'),
(3, 'almond waffle ', NULL, 150.00, NULL, 'almond_waffle.jpeg', '2026-04-25 11:42:46', 'waffles'),
(4, 'chocolate cookie', NULL, 100.00, NULL, 'chocolate_cookies.jpeg', '2026-04-25 11:44:54', 'cookies'),
(5, 'walnut brownie', NULL, 200.00, NULL, 'walnut_brownie.jpeg', '2026-04-25 11:46:11', 'brownies'),
(6, 'biscoff cheesecake', NULL, 200.00, NULL, 'biscoff_cheesecake.jpeg', '2026-04-25 11:47:01', 'cheesecake'),
(7, 'chocolate cake', NULL, 350.00, NULL, 'trufflecake.jpeg', '2026-04-25 11:55:43', 'cakes'),
(8, 'redvelwet cake', NULL, 400.00, NULL, 'red_velvet_cake.jpeg', '2026-04-25 11:56:29', 'cakes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'rajvi', 'rp@gmail.com', '1234567890', '$2y$10$lfS3BqIIfMrPYVM8z2Zh6u81jM7e0tYaxgXu8rUSx.dGCffRdmAh2', '2026-04-25 08:44:05'),
(2, 'Prathama', 'pa@gmail.com', '1234567890', '$2y$10$JHOamWkTMa7bHqnPsXBLEubquavFebucG7/WbHiyfrIgxgmi2JTEy', '2026-04-25 15:30:21'),
(3, 'Dhruvi', 'dhruvi@gmail.com', '7810264330', '$2y$10$ln1Td5zm/xEdg5iPucDIA.sl71h/7frEoXkXq/SyT9KfoyFCbW/xm', '2026-04-28 12:03:41'),
(4, 'Guddy', 'guddy@gmail.com', '1547809246', '$2y$10$ORlFvqAm8Xx3IJfulA/VWu00pzrAi0aNz/8mXWGCjPfpCH2/sLBqu', '2026-04-28 12:07:30'),
(5, 'tilak', 'tp@gmail.com', '9812354701', '$2y$10$c6/xQY8.b/7EtPvsmVINsOFOLq3K/h4cAFhyBzIPENogz3zATWVtS', '2026-04-28 12:12:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_orders`
--
ALTER TABLE `custom_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_persons`
--
ALTER TABLE `delivery_persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `custom_orders`
--
ALTER TABLE `custom_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_persons`
--
ALTER TABLE `delivery_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
