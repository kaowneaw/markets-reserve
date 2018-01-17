-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 17, 2018 at 11:11 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `markets`
--

-- --------------------------------------------------------

--
-- Table structure for table `markets`
--

CREATE TABLE `markets` (
  `markets_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `map_img` text NOT NULL,
  `userId` int(11) NOT NULL,
  `description` text NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`markets_id`, `name`, `map_img`, `userId`, `description`, `create_date`) VALUES
(24, 'จตุจักร', 'uploads/1514782329map.jpg', 1, 'ตลาดนัด จตุจักร', '2018-01-01 20:59:23'),
(31, 'เจเจ', 'uploads/1514815798map.jpg', 1, '', '2018-01-01 21:09:58'),
(32, 'Jatujak Park Market', 'uploads/1514815851map.jpg', 2, 'เปิดทุกวันหยุดนะคะ', '2018-01-03 22:20:20'),
(34, 'เจเจกรีน', 'uploads/1514816004map.jpg', 2, 'หฟกหก', '2018-01-02 09:08:37'),
(35, 'T', 'uploads/1514862187map.jpg', 2, '', '2018-01-02 10:03:06'),
(36, 'จตุกจักร 2 หมอชิต', 'uploads/1515511015map.jpg', 2, 'มาคร้า', '2018-01-09 22:16:54'),
(37, 'a', 'uploads/1516085450map.jpg', 6, 'a', '2018-01-16 13:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `markets_img`
--

CREATE TABLE `markets_img` (
  `markets_img_id` int(11) NOT NULL,
  `img_url` text NOT NULL,
  `market_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `markets_img`
--

INSERT INTO `markets_img` (`markets_img_id`, `img_url`, `market_id`) VALUES
(4, 'uploads/1513751848.jpg', 11),
(5, 'uploads/1513752248.jpg', 12),
(6, 'uploads/1513752276.jpg', 13),
(7, 'uploads/1513752281.jpg', 14),
(8, 'uploads/1513752681.jpg', 15),
(9, 'uploads/1513752725.jpg', 16),
(10, 'uploads/1513753107.jpg', 17),
(11, 'uploads/1513753122.jpg', 18),
(12, 'uploads/1513753135.jpg', 19),
(13, 'uploads/1513840517.jpg', 20),
(14, 'uploads/1513913505.jpg', 21),
(15, 'uploads/1513914041.jpg', 22),
(16, 'uploads/1513914121.jpg', 23),
(17, 'uploads/1514815163.jpg', 24),
(18, 'uploads/1514641873.jpg', 29),
(19, 'uploads/1514642217.jpg', 30),
(20, 'uploads/1514815798.jpg', 31),
(21, 'uploads/1514861744.jpg', 32),
(22, 'uploads/1514815987.jpg', 33),
(23, 'uploads/1514816004.jpg', 34),
(24, 'uploads/1514862187.jpg', 35),
(25, 'uploads/1515511015.jpg', 36),
(26, 'uploads/1516085450.jpg', 37);

-- --------------------------------------------------------

--
-- Table structure for table `markets_type`
--

CREATE TABLE `markets_type` (
  `markets_type_id` int(11) NOT NULL,
  `market_type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `markets_type`
--

INSERT INTO `markets_type` (`markets_type_id`, `market_type_name`) VALUES
(1, 'รายวัน'),
(2, 'รายเดือน'),
(3, 'รายปี');

-- --------------------------------------------------------

--
-- Table structure for table `market_store`
--

CREATE TABLE `market_store` (
  `store_market_id` int(11) NOT NULL,
  `store_name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `markets_id` int(11) NOT NULL,
  `pointX` text NOT NULL,
  `pointY` text NOT NULL,
  `width` varchar(20) NOT NULL,
  `height` varchar(20) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  `water_price_per_unit` float NOT NULL,
  `eletric_price_per_unit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `market_store`
--

INSERT INTO `market_store` (`store_market_id`, `store_name`, `type_id`, `markets_id`, `pointX`, `pointY`, `width`, `height`, `price`, `description`, `water_price_per_unit`, `eletric_price_per_unit`) VALUES
(27, '', 1, 24, '42.90591805766313', '51.44375646460156', '', '', 150, '', 0, 0),
(31, '', 1, 24, '36.83611532625189', '49.69619785858537', '', '', 1500, '', 0, 0),
(32, '', 2, 24, '52.69347496206373', '48.931640968453294', '', '', 3500, '', 0, 0),
(33, '', 1, 24, '49.12746585735964', '49.259308207081325', '', '', 150, '', 0, 0),
(35, 'ซอย 899999', 1, 32, '47.365153814319214', '50.81787184523089', '', '', 150, '', 0, 0),
(36, 'ซอย 8898988', 1, 32, '47.610015174506835', '50.77250982215579', '', '', 150, '', 0, 0),
(37, 'ซอย 8', 2, 32, '47.823406676783', '50.76072828948087', '', '', 1500, '', 20, 7),
(38, 'ซอย8', 1, 32, '47.989377845220034', '50.73342289502713', '', '', 120, '', 0, 0),
(41, 'ซอย 9', 1, 32, '51.17602427921093', '47.83941683969317', '', '', 150, '', 20, 7),
(42, 'o', 1, 32, '48.193285280728375', '50.77438098670773', '', '', 150, '', 10, 7),
(43, 'kbank', 1, 36, '47.23065250379362', '45.3273013435449', '', '', 150, '-', 10, 7),
(44, '1', 1, 37, '45.220030349013655', '39.411566346315965', '1234', '12', 1, '', 1, 1),
(45, '2', 2, 37, '48.10318664643399', '38.17231495531951', '2', '2', 2, '', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `store_booking`
--

CREATE TABLE `store_booking` (
  `store_booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_booking`
--

INSERT INTO `store_booking` (`store_booking_id`, `user_id`, `create_date`, `status`) VALUES
(8, 2, '2018-01-09 20:14:38', 'WAIT'),
(9, 2, '2018-01-09 21:13:11', 'WAIT'),
(10, 2, '2018-01-09 21:16:21', 'WAIT'),
(11, 2, '2018-01-09 21:28:28', 'WAIT'),
(12, 2, '2018-01-09 22:18:54', 'WAIT'),
(13, 2, '2018-01-16 14:21:59', 'WAIT');

-- --------------------------------------------------------

--
-- Table structure for table `store_booking_detail`
--

CREATE TABLE `store_booking_detail` (
  `store_booking_detail_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `water_price_per_unit` float NOT NULL,
  `eletric_price_per_unit` float NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_booking_detail`
--

INSERT INTO `store_booking_detail` (`store_booking_detail_id`, `booking_id`, `store_id`, `price`, `water_price_per_unit`, `eletric_price_per_unit`, `start_date`, `end_date`) VALUES
(3, 8, 31, 0, 0, 0, '2018-01-09', '2018-01-12'),
(4, 9, 31, 0, 0, 0, '2018-01-09', '2018-01-09'),
(5, 10, 27, 0, 0, 0, '2018-01-09', '2018-01-09'),
(6, 11, 33, 0, 0, 0, '2018-01-09', '2018-01-09'),
(7, 12, 43, 0, 0, 0, '2018-01-09', '2018-01-19'),
(8, 13, 44, 1, 1, 1, '2018-01-16', '2018-01-16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `id_card` varchar(13) NOT NULL,
  `type` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `password`, `first_name`, `last_name`, `tel`, `id_card`, `type`, `role`) VALUES
(1, 'yy', '2fb1c5cf58867b5bbc9a1b145a86f3a0', 'yyy', 'yyy', '4545345345', '', 'MERCHANT', 'USER'),
(2, 'k1', '225bc7ac4aaa1e606a628e990fe2d398', 'panya', 'n', '0859827882', '', 'MERCHANT', 'USER'),
(3, 'k2', '225bc7ac4aaa1e606a628e990fe2d398', 'qq', 'qq', '0859827882', '', 'MERCHANT', 'USER'),
(4, 'k3', '225bc7ac4aaa1e606a628e990fe2d398', 'k3', 'wewqe', '0859827882', '1251514444545', 'MERCHANT', 'USER'),
(5, 'k5', '225bc7ac4aaa1e606a628e990fe2d398', 'k5', 'qwe', '657676', '67567', 'MARKET', 'USER'),
(6, 'k4', '225bc7ac4aaa1e606a628e990fe2d398', 'k4', 'k4', '111111111', '1111111', 'MARKET', 'USER');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `markets`
--
ALTER TABLE `markets`
  ADD PRIMARY KEY (`markets_id`);

--
-- Indexes for table `markets_img`
--
ALTER TABLE `markets_img`
  ADD PRIMARY KEY (`markets_img_id`);

--
-- Indexes for table `markets_type`
--
ALTER TABLE `markets_type`
  ADD PRIMARY KEY (`markets_type_id`);

--
-- Indexes for table `market_store`
--
ALTER TABLE `market_store`
  ADD PRIMARY KEY (`store_market_id`);

--
-- Indexes for table `store_booking`
--
ALTER TABLE `store_booking`
  ADD PRIMARY KEY (`store_booking_id`);

--
-- Indexes for table `store_booking_detail`
--
ALTER TABLE `store_booking_detail`
  ADD PRIMARY KEY (`store_booking_detail_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `markets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `markets_img`
--
ALTER TABLE `markets_img`
  MODIFY `markets_img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `markets_type`
--
ALTER TABLE `markets_type`
  MODIFY `markets_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `market_store`
--
ALTER TABLE `market_store`
  MODIFY `store_market_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `store_booking`
--
ALTER TABLE `store_booking`
  MODIFY `store_booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `store_booking_detail`
--
ALTER TABLE `store_booking_detail`
  MODIFY `store_booking_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;