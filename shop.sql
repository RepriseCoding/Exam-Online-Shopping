-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2020 at 03:44 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` double NOT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT 0,
  `product_type` int(11) NOT NULL,
  `product_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_code`, `product_name`, `product_price`, `product_quantity`, `product_type`, `product_img`) VALUES
(1, 'M001', 'เมาส์ Logitech', 500, 10, 1, 'images/products/m001.jpg'),
(2, 'K001', 'คีย์บอร์ด Xanova', 3999, 10, 2, 'images/products/k001.jpg'),
(3, 'LT001', 'โน๊ตบุ๊ค Msi', 39999, 10, 3, 'images/products/lt001.jpg'),
(4, 'HS001', 'หูฟัง Senheiser', 7900, 10, 4, 'images/products/hs001.jpeg'),
(5, 'HS002', 'หูฟัง Corsair', 5900, 10, 4, 'images/products/hs002.jpg'),
(6, 'HS003', 'หูฟัง HyperX', 3590, 10, 4, 'images/products/hs003.jpg'),
(7, 'K002', 'คีย์บอร์ด Razor', 3990, 10, 2, 'images/products/k002.jpg'),
(8, 'K003', 'คีย์บอร์ด Logitech', 5690, 10, 2, 'images/products/k003.png'),
(9, 'LT002', 'โน๊ตบุ๊ค Razor', 35900, 10, 3, 'images/products/lt002.jpg'),
(10, 'LT003', 'โน๊ตบุ๊ค Asus', 59600, 10, 3, 'images/products/lt003.jpg'),
(11, 'M002', 'เมาส์ Zowie pink', 3000, 10, 1, 'images/products/m002.jpg'),
(12, 'M003', 'เมาส์ Zowie', 2900, 10, 1, 'images/products/m003.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
