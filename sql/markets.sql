-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 22, 2017 at 11:32 AM
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
(20, 'AA', 'uploads/1513840517.jpg', 1, 'wewewewe', '0000-00-00 00:00:00'),
(21, 'BBB', 'uploads/1513913505.jpg', 1, 'BBB', '0000-00-00 00:00:00'),
(22, 'CCC', 'uploads/1513914041.jpg', 1, 'CCC', '2017-12-22 04:40:41'),
(23, 'RR', 'uploads/1513914121.jpg', 1, 'RRR', '2017-12-22 10:42:01');

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
(16, 'uploads/1513914121.jpg', 23);

-- --------------------------------------------------------

--
-- Table structure for table `markets_type`
--

CREATE TABLE `markets_type` (
  `markets_type_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `markets_type`
--

INSERT INTO `markets_type` (`markets_type_id`, `name`) VALUES
(1, 'รายวัน'),
(2, 'รายเดือน'),
(3, 'รายปี');

-- --------------------------------------------------------

--
-- Table structure for table `market_store`
--

CREATE TABLE `market_store` (
  `store_market_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `markets_id` int(11) NOT NULL,
  `pointX` text NOT NULL,
  `pointY` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `market_store`
--

INSERT INTO `market_store` (`store_market_id`, `type_id`, `markets_id`, `pointX`, `pointY`, `status`, `price`, `description`) VALUES
(5, 1, 20, '27.09030100334448', '38.767436316660124', 'AVAILBLE', 120, '12323123'),
(6, 1, 20, '27.09030100334448', '38.767436316660124', 'AVAILBLE', 120, '12323123'),
(7, 1, 20, '29.93311036789298', '45.268807624423005', 'AVAILBLE', 120, ''),
(8, 1, 20, '44.98327759197324', '27.20944288063723', 'AVAILBLE', 120, ''),
(11, 1, 20, '32.80936454849498', '41.99262721189663', 'AVAILBLE', 300, ''),
(12, 1, 20, '44.481605351170565', '27.450234410554376', 'AVAILBLE', 300, '');

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
  `tel` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `password`, `first_name`, `last_name`, `tel`, `type`, `role`) VALUES
(1, 'yy', '2fb1c5cf58867b5bbc9a1b145a86f3a0', 'yyy', 'yyy', '4545345345', 'MERCHANT', 'USER');

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
  MODIFY `markets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `markets_img`
--
ALTER TABLE `markets_img`
  MODIFY `markets_img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `markets_type`
--
ALTER TABLE `markets_type`
  MODIFY `markets_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `market_store`
--
ALTER TABLE `market_store`
  MODIFY `store_market_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;