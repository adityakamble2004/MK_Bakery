-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 06:49 AM
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
-- Database: `bakery_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending',
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `category`, `price`, `stock_quantity`, `description`, `image_url`) VALUES
(1, 'Chocolate Cake', 'Cake', 350.00, 10, 'Delicious chocolate cake with rich cocoa flavor.', 'FULLY-LOADED-CHOCOLATE-TRUFFLE-CAKE-1.jpg'),
(2, 'Strawberry Muffin', NULL, 120.00, NULL, 'Soft and fluffy muffin with fresh strawberries.', 'strawberry_muffin.jpg'),
(3, 'Blueberry Cheesecake', NULL, 400.00, NULL, 'Creamy cheesecake topped with fresh blueberries.', 'blueberry_cheesecake.jpg'),
(4, 'Vanilla Cupcake', 'Cake', 80.00, 10, 'Classic vanilla cupcake with buttercream frosting.', 'FULLY-LOADED-CHOCOLATE-TRUFFLE-CAKE-1.jpg'),
(5, 'Almond Croissant', NULL, 150.00, NULL, 'Crispy and flaky croissant filled with almond cream.', 'almond_croissant.jpg'),
(6, 'Red Velvet Cake', NULL, 380.00, NULL, 'Smooth and velvety red velvet cake with cream cheese frosting.', 'red_velvet_cake.jpg'),
(7, 'Chocolate Chip Cookies', NULL, 90.00, NULL, 'Crunchy cookies loaded with chocolate chips.', 'chocolate_chip_cookies.jpg'),
(8, 'Black Forest Cake', NULL, 450.00, NULL, 'Classic black forest cake with layers of chocolate and cherries.', 'black_forest_cake.jpg'),
(9, 'Fruit Tart', NULL, 300.00, NULL, 'Crunchy tart filled with custard and topped with fresh fruits.', 'fruit_tart.jpg'),
(10, 'Brownie', NULL, 110.00, NULL, 'Rich and fudgy chocolate brownie with walnuts.', 'brownie.jpg'),
(11, 'Coffee Mousse', NULL, 250.00, NULL, 'Light and creamy coffee-flavored mousse.', 'coffee_mousse.jpg'),
(12, 'Butter Croissant', NULL, 100.00, NULL, 'Buttery and flaky croissant with a golden crust.', 'butter_croissant.jpg'),
(13, 'Carrot Cake', NULL, 320.00, NULL, 'Spiced carrot cake with a creamy frosting.', 'carrot_cake.jpg'),
(14, 'Lemon Tart', NULL, 270.00, NULL, 'Tangy lemon tart with a crispy crust.', 'lemon_tart.jpg'),
(15, 'Pineapple Pastry', NULL, 200.00, NULL, 'Soft sponge cake with layers of pineapple cream.', 'pineapple_pastry.jpg'),
(16, 'Raspberry Macaron', NULL, 160.00, NULL, 'Sweet and crispy macaron with raspberry filling.', 'raspberry_macaron.jpg'),
(17, 'Mocha Cake', NULL, 350.00, NULL, 'Coffee and chocolate-infused cake with a rich texture.', 'mocha_cake.jpg'),
(18, 'Oreo Cheesecake', NULL, 410.00, NULL, 'Cheesecake loaded with Oreo crumbs and a crunchy base.', 'oreo_cheesecake.jpg'),
(19, 'Walnut Brownie', NULL, 120.00, NULL, 'Chocolate brownie topped with caramelized walnuts.', 'walnut_brownie.jpg'),
(20, 'Mango Mousse', NULL, 280.00, NULL, 'Smooth and creamy mango mousse.', 'mango_mousse.jpg'),
(21, 'cake', 'cake', 10.00, 50, 'made with some thing', 'FULLY-LOADED-CHOCOLATE-TRUFFLE-CAKE-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `staff_username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(512) NOT NULL,
  `role` enum('admin','manager','cashier','superadmin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `username`, `staff_username`, `email`, `phone`, `password`, `role`) VALUES
(4, 'Admin User', '', 'admin123', 'ak8806657127@gmail.com', NULL, '$2y$10$qR8fXh4bFQMM0wLI4dBN7uH/7JiROJul54IXV9DejEEh19gePIqvS', 'admin'),
(5, 'Manager User', '', 'manager123', '', NULL, '$2y$10$qR8fXh4bFQMM0wLI4dBN7uH/7JiROJul54IXV9DejEEh19gePIqvS', 'manager'),
(6, 'Cashier User', '', 'cashier123', '', NULL, '$2y$10$qR8fXh4bFQMM0wLI4dBN7uH/7JiROJul54IXV9DejEEh19gePIqvS', 'cashier'),
(7, 'adi', 'adi', '', '', NULL, '$2y$10$1YUbQ/o4K8aOA7SzK8iwX.Iu32vRCKpBE.Rh4vBhCZaqDqJzzcrSS', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`staff_username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
