-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 29, 2024 at 06:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `czyrahs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `fname`, `mname`, `lname`, `username`, `password`, `email`, `birthday`, `address`, `contact`, `type`) VALUES
(1, '', '', '', 'Tobey24', '052402', 'ewantobeyramones@gmail.com', '2002-05-24', 'Caloocan', '', 'Admin'),
(2, '', '', '', 'Rosalyn', '052402', 'rosalynnazario@gmail.com', '1999-06-29', '', '', 'Rider'),
(8, 'Johnrick', 'N/A', 'Alejandro', 'Johnrick', '052402', 'Johnrick@gmailcom', '2024-02-02', 'Malabon', '1241212512', 'User'),
(9, 'Ewan Tobey', 'Salon', 'Ramones', 'agay', '2424', 'rosalynnazario@gmail.com', '2024-02-14', 'test', '1234', 'Employee'),
(14, 'waws', 'waw', 'waws', 'waw', 'waw', 'waw@gmail.com', '2024-02-01', 'waws', '231312', 'User'),
(20, 'asdasd2', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasd@gmail.com', '0000-00-00', 'asdas', '21321', 'asda'),
(21, 'test', 'test', 'test', 'test', 'test', 'test@gmail.com', '0000-00-00', 'test', '213', 'test'),
(22, 'vbnvbn', 'vbnvbn', 'vbnvbn', 'vbnvbn', 'vbnvbn', 'nvbnbv@gmail.com', '0000-00-00', 'mbnmbn', '453436', 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pizzaname` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `orderlocator` varchar(255) NOT NULL,
  `orderlimit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `username`, `pizzaname`, `price`, `orderlocator`, `orderlimit`) VALUES
(139, 'Tobey24', 'Hawaiian', '85', 'ORD5759', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu1`
--

CREATE TABLE `menu1` (
  `id` int(11) NOT NULL,
  `image` varchar(60) NOT NULL,
  `PizzaName` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu1`
--

INSERT INTO `menu1` (`id`, `image`, `PizzaName`, `Description`, `Price`) VALUES
(20, 'uploads/ham_and_cheese.jpg', 'Ham and Cheese', 'A Cheeselycious Pizza filled with many Cheesse combined with Ham that instantly melts in your mouth leaving a flavoured lasting smell!', 76),
(21, 'uploads/hawaiian.jpg', 'Hawaiian', 'Really who eat this stuff?', 85),
(23, 'uploads/bacon.jpg', 'Bacon', 'More sides! More the Fun! Filled with Cheesylicious Cheese that is very Tasteful', 95),
(36, 'uploads/pepperoni.jpg', 'Vegetarian', 'So you a Goat now?', 95),
(38, 'uploads/pepperoni.jpg', 'Pepperoni', 'Perfect Pizza for Pepperoni Lover!', 85);

-- --------------------------------------------------------

--
-- Table structure for table `orderhandler`
--

CREATE TABLE `orderhandler` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pizzaname` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `totalprice` int(11) NOT NULL,
  `orderlocator` varchar(255) NOT NULL,
  `orderlimit` int(11) NOT NULL,
  `orderstatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderhandler`
--

INSERT INTO `orderhandler` (`id`, `username`, `pizzaname`, `price`, `quantity`, `totalprice`, `orderlocator`, `orderlimit`, `orderstatus`) VALUES
(118, 'Johnrick', 'Hawaiian', 85, 10, 850, 'ORD4084', 0, 'Finish Process'),
(119, 'Johnrick', 'Pepperoni', 85, 5, 425, 'ORD3539', 0, 'Finish Process'),
(120, 'Johnrick', 'Bacon', 95, 1, 95, 'ORD2501', 0, 'Finish Process'),
(121, 'Johnrick', 'Bacon', 95, 2, 190, 'ORD9389', 0, 'Finish Process'),
(122, 'Johnrick', 'Pepperoni', 85, 3, 255, 'ORD4910', 0, 'On Checking');

-- --------------------------------------------------------

--
-- Table structure for table `pos`
--

CREATE TABLE `pos` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `customer_tag` varchar(255) NOT NULL,
  `pizzaname` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `orderstatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos`
--

INSERT INTO `pos` (`id`, `user`, `customer_tag`, `pizzaname`, `price`, `quantity`, `orderstatus`) VALUES
(3, 'Johnrick', '2Bee', 'Ham and Cheese', 76, 3, 'Finish Process'),
(4, 'Johnrick', '2Bee', 'Ham and Cheese', 76, 1, 'Cooking'),
(5, 'Johnrick', '2Bee', 'Pepperoni', 85, 3, 'Cooking'),
(6, 'Johnrick', '2Bee', 'Ham and Cheese', 76, 1, 'Pending'),
(7, 'Johnrick', '2Bee', 'Bacon', 95, 3, 'Pending'),
(8, 'Johnrick', '2Bee', 'Ham and Cheese', 76, 1, 'Pending'),
(10, 'Rosalyn', 'Kalbo', 'Hawaiian', 85, 1, 'Finish Process'),
(11, 'Rosalyn', 'Kalbo', 'Pepperoni', 85, 2, 'Finish Process');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu1`
--
ALTER TABLE `menu1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderhandler`
--
ALTER TABLE `orderhandler`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos`
--
ALTER TABLE `pos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `menu1`
--
ALTER TABLE `menu1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orderhandler`
--
ALTER TABLE `orderhandler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `pos`
--
ALTER TABLE `pos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
