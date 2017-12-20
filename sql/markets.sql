-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 20, 2017 at 08:54 AM
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
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `map_img` text NOT NULL,
  `userId` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`id`, `name`, `map_img`, `userId`, `description`) VALUES
(11, 'aAA', '', 1, 'AAAA'),
(12, 'ABCDE', '', 1, 'TETETETETETETETET'),
(13, 'VBB', '', 1, 'BB'),
(14, 'aa', '', 1, 'BB'),
(15, 'a', '', 1, 'a'),
(16, '12321313211321313', '', 1, 'ertrtetrtet'),
(17, 'rt', '', 1, 'er'),
(18, 'rt', '', 1, 'er'),
(19, 'asd', '', 1, 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `markets_img`
--

CREATE TABLE `markets_img` (
  `id` int(11) NOT NULL,
  `img_url` text NOT NULL,
  `market_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `markets_img`
--

INSERT INTO `markets_img` (`id`, `img_url`, `market_id`) VALUES
(4, 'uploads/1513751848.jpg', 11),
(5, 'uploads/1513752248.jpg', 12),
(6, 'uploads/1513752276.jpg', 13),
(7, 'uploads/1513752281.jpg', 14),
(8, 'uploads/1513752681.jpg', 15),
(9, 'uploads/1513752725.jpg', 16),
(10, 'uploads/1513753107.jpg', 17),
(11, 'uploads/1513753122.jpg', 18),
(12, 'uploads/1513753135.jpg', 19);

-- --------------------------------------------------------

--
-- Table structure for table `store_market`
--

CREATE TABLE `store_market` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `pointX` text NOT NULL,
  `pointY` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `store_type`
--

CREATE TABLE `store_type` (
  `id` int(11) NOT NULL,
  `type_name` int(11) NOT NULL,
  `price` float NOT NULL,
  `color` varchar(20) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_type`
--

INSERT INTO `store_type` (`id`, `type_name`, `price`, `color`, `description`) VALUES
(1, 111, 111, '111', '1111');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `markets`
--
ALTER TABLE `markets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `markets_img`
--
ALTER TABLE `markets_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_market`
--
ALTER TABLE `store_market`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_type`
--
ALTER TABLE `store_type`
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
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `markets_img`
--
ALTER TABLE `markets_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `store_market`
--
ALTER TABLE `store_market`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `store_type`
--
ALTER TABLE `store_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;