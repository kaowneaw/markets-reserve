-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2018 at 03:43 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `markets`
--

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `contract_id` int(11) NOT NULL,
  `contract_img` text NOT NULL,
  `store_booking_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `location` varchar(100) NOT NULL,
  `deposit` float NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`markets_id`, `name`, `map_img`, `userId`, `description`, `location`, `deposit`, `create_date`) VALUES
(24, 'จตุจักร', 'uploads/1514782329map.jpg', 1, 'ตลาดนัด จตุจักร', '', 0, '2018-01-01 20:59:23'),
(31, 'เจเจ', 'uploads/1514815798map.jpg', 1, '', '', 0, '2018-01-01 21:09:58'),
(32, 'Jatujak Park Market', 'uploads/1514815851map.jpg', 2, 'เปิดทุกวันหยุดนะคะ', '', 0, '2018-01-03 22:20:20'),
(34, 'เจเจกรีน', 'uploads/1514816004map.jpg', 2, 'หฟกหก', '', 0, '2018-01-02 09:08:37'),
(35, 'T', 'uploads/1514862187map.jpg', 2, '', '', 0, '2018-01-02 10:03:06'),
(36, 'จตุกจักร 2 หมอชิต', 'uploads/1515511015map.jpg', 2, 'มาคร้า', '', 0, '2018-01-09 22:16:54'),
(37, 'a', 'uploads/1518705351map.jpg', 6, 'Yeah', 'No', 200, '2018-02-15 21:35:51'),
(38, 'H', 'uploads/1518752156map.jpg', 5, 'G', 'G', 1000, '2018-02-16 10:35:56'),
(39, 'q', 'uploads/1517471749map.jpeg', 5, '1', '1', 1000, '2018-02-01 14:55:48');

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
(26, 'uploads/1518705351.jpg', 37),
(27, 'uploads/1518752156.jpg', 38),
(28, 'uploads/1517471749.jpeg', 39);

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
  `zone` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  `water_price_per_unit` float NOT NULL,
  `eletric_price_per_unit` float NOT NULL,
  `size_marker` int(11) NOT NULL DEFAULT '20',
  `angle_marker` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `market_store`
--

INSERT INTO `market_store` (`store_market_id`, `store_name`, `type_id`, `markets_id`, `pointX`, `pointY`, `width`, `height`, `zone`, `price`, `description`, `water_price_per_unit`, `eletric_price_per_unit`, `size_marker`, `angle_marker`) VALUES
(27, '', 1, 24, '42.90591805766313', '51.44375646460156', '', '', '', 150, '', 0, 0, 20, 0),
(31, '', 1, 24, '36.83611532625189', '49.69619785858537', '', '', '', 1500, '', 0, 0, 20, 0),
(32, '', 2, 24, '52.69347496206373', '48.931640968453294', '', '', '', 3500, '', 0, 0, 20, 0),
(33, '', 1, 24, '49.12746585735964', '49.259308207081325', '', '', '', 150, '', 0, 0, 20, 0),
(35, 'ซอย 899999', 1, 32, '47.365153814319214', '50.81787184523089', '', '', '', 150, '', 0, 0, 20, 0),
(36, 'ซอย 8898988', 1, 32, '47.610015174506835', '50.77250982215579', '', '', '', 150, '', 0, 0, 20, 0),
(37, 'ซอย 8', 2, 32, '47.823406676783', '50.76072828948087', '', '', '', 1500, '', 20, 7, 20, 0),
(38, 'ซอย8', 1, 32, '47.989377845220034', '50.73342289502713', '', '', '', 120, '', 0, 0, 20, 0),
(41, 'ซอย 9', 1, 32, '51.17602427921093', '47.83941683969317', '', '', '', 150, '', 20, 7, 20, 0),
(42, 'o', 1, 32, '48.193285280728375', '50.77438098670773', '', '', '', 150, '', 10, 7, 20, 0),
(43, 'kbank', 1, 36, '47.23065250379362', '45.3273013435449', '', '', '', 150, '-', 10, 7, 20, 0),
(44, '1', 1, 37, '45.220030349013655', '39.411566346315965', '1234', '12', '', 1, '', 1, 1, 20, 0),
(45, '2', 2, 37, '48.10318664643399', '38.17231495531951', '2', '2', '', 2, '', 2, 2, 20, 0),
(60, '8', 1, 37, '82.50173936302636', '50.88375827436574', '8', '8', '88', 8, '-', 8, 8, 49, 47),
(61, '8', 1, 37, '55.632076929118455', '10.565168527537839', '8', '8', '8', 8, '-', 8, 8, 50, 41),
(62, '8', 1, 37, '77.64424858035376', '5.663312769199115', '8', '8', '88', 8, '-', 8, 8, 122, 42),
(63, '7', 1, 37, '27.802703811112956', '8.294310302018403', '7', '7', '7', 7, '-', 7, 7, 39, 43);

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE `payment_info` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `account_id` varchar(20) NOT NULL,
  `account_bank` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `report_transfer`
--

CREATE TABLE `report_transfer` (
  `report_transfer_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `bank_account_from` varchar(50) NOT NULL,
  `bank_account_to` varchar(50) NOT NULL,
  `attachment` varchar(50) NOT NULL,
  `booking_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `report_transfer`
--

INSERT INTO `report_transfer` (`report_transfer_id`, `date_time`, `bank_account_from`, `bank_account_to`, `attachment`, `booking_id`) VALUES
(1, '2018-02-16 16:38:00', 'ธนาคารกสิกรไทย', 'ธนาคารกสิกรไทย', 'uploads/1518773893.jpg', 1),
(2, '2018-02-16 19:41:00', 'ธนาคารกรุงเทพ', 'ธนาคารกรุงเทพ', 'uploads/1518784906.jpg', 4),
(3, '2018-02-16 19:55:00', 'ธนาคารกรุงเทพ', 'ธนาคารกรุงเทพ', 'uploads/1518785724.jpg', 3),
(4, '2018-02-16 21:17:00', 'ธนาคารกรุงเทพ', 'ธนาคารกรุงเทพ', 'uploads/1518790668.jpg', 8),
(5, '2018-02-16 21:17:00', 'ธนาคารกรุงเทพ', 'ธนาคารกรุงเทพ', 'uploads/1518790680.jpg', 7),
(6, '2018-02-16 21:30:00', 'ธนาคารกรุงเทพ', 'ธนาคารกรุงเทพ', 'uploads/1518791457.jpg', 6),
(8, '2018-02-16 21:34:00', 'ธนาคารกรุงเทพ', 'ธนาคารกรุงเทพ', 'uploads/1518791653.jpg', 5),
(9, '2018-02-16 21:35:00', 'ธนาคารกรุงเทพ', 'ธนาคารกรุงเทพ', 'uploads/1518791754.jpg', 9),
(10, '2018-02-16 21:36:00', 'ธนาคารกรุงเทพ', 'ธนาคารกรุงเทพ', 'uploads/1518791793.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `store_booking`
--

CREATE TABLE `store_booking` (
  `store_booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `market_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_booking`
--

INSERT INTO `store_booking` (`store_booking_id`, `user_id`, `market_id`, `create_date`, `status`) VALUES
(5, 2, 37, '2018-02-16 21:16:46', 'REPORTED'),
(6, 2, 37, '2018-02-16 21:17:00', 'REPORTED'),
(7, 2, 37, '2018-02-16 21:17:16', 'APPROVE'),
(8, 2, 37, '2018-02-16 21:17:38', 'REPORTED'),
(9, 2, 37, '2018-02-16 21:35:46', 'REPORTED'),
(10, 2, 37, '2018-02-16 21:36:25', 'REPORTED');

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
(5, 5, 63, 7, 7, 7, '2018-02-16', '2018-02-16'),
(6, 6, 63, 7, 7, 7, '2018-02-17', '2018-02-17'),
(7, 7, 63, 7, 7, 7, '2018-02-18', '2018-02-18'),
(8, 8, 63, 7, 7, 7, '2018-02-20', '2018-02-20'),
(9, 9, 44, 1, 1, 1, '2018-02-16', '2018-02-16'),
(10, 10, 60, 8, 8, 8, '2018-02-16', '2018-02-16');

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
  `address` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `img` text NOT NULL,
  `id_card` varchar(13) NOT NULL,
  `type` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `isUsePromtPay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `username`, `password`, `first_name`, `last_name`, `tel`, `address`, `email`, `img`, `id_card`, `type`, `role`, `status`, `isUsePromtPay`) VALUES
(2, 'k1', '225bc7ac4aaa1e606a628e990fe2d398', 'TJ', 'TJ', '0859827882', 'ryrytytytyrtytry', 'e@gmail.com', 'uploads/1517019159.jpg', '11321324434', 'MERCHANT', 'USER', 1, 0),
(3, 'k2', '225bc7ac4aaa1e606a628e990fe2d398', 'qq', 'qq', '0859827882', '', '', '', '', 'MERCHANT', 'USER', 0, 0),
(4, 'k3', '225bc7ac4aaa1e606a628e990fe2d398', 'k3', 'wewqe', '0859827882', '', '', '', '1251514444545', 'MERCHANT', 'USER', 1, 0),
(5, 'k5', '225bc7ac4aaa1e606a628e990fe2d398', 'k5', 'qwe', '085982788211111', '', 'g@r.com', 'uploads/1517815714.jpg', '67567', 'MARKET', 'USER', 1, 0),
(6, 'k4', '225bc7ac4aaa1e606a628e990fe2d398', 'k4', 'k4', '0859827882', '', 'h@gmail.com', '', '1111111', 'MARKET', 'USER', 1, 1),
(12, 'g1', '225bc7ac4aaa1e606a628e990fe2d398', 'qqqH', 'wqwqwqw', '2323233', '777777', 'e@gmail.com', 'uploads/1516959403.jpeg', '2324342345', 'MERCHANT', 'USER', 1, 0),
(13, 'g2', '225bc7ac4aaa1e606a628e990fe2d398', 'aAA', 'AAA', '11111', 'sfdsfsdfsfdsf', '1111@gmail.com', 'uploads/1516952149.jpg', '11111', 'MERCHANT', 'USER', 1, 0),
(14, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', '123456789', 'admin', 'admin@gmail.com', 'uploads/1516952322.jpg', '1111111111111', 'ADMIN', 'ADMIN', 1, 0),
(15, 'g5', '225bc7ac4aaa1e606a628e990fe2d398', 'g', 'g', '1234', 'fdsgdfgfgfdgfgfdg', 'g@g', 'uploads/1516960638.jpg', '1234', 'MERCHANT', 'USER', 0, 0),
(16, 'k6', '225bc7ac4aaa1e606a628e990fe2d398', 'Paliopm', 'Paliopm', '0859827882', 'th', 'er@gmail.com', 'uploads/1518773853.jpg', '1102001820043', 'MERCHANT', 'USER', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`contract_id`);

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
-- Indexes for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `report_transfer`
--
ALTER TABLE `report_transfer`
  ADD PRIMARY KEY (`report_transfer_id`);

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
  ADD PRIMARY KEY (`users_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `contract_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `markets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `markets_img`
--
ALTER TABLE `markets_img`
  MODIFY `markets_img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `markets_type`
--
ALTER TABLE `markets_type`
  MODIFY `markets_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `market_store`
--
ALTER TABLE `market_store`
  MODIFY `store_market_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `payment_info`
--
ALTER TABLE `payment_info`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report_transfer`
--
ALTER TABLE `report_transfer`
  MODIFY `report_transfer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `store_booking`
--
ALTER TABLE `store_booking`
  MODIFY `store_booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `store_booking_detail`
--
ALTER TABLE `store_booking_detail`
  MODIFY `store_booking_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `resetReserve` ON SCHEDULE EVERY 1 HOUR STARTS '2018-02-15 22:22:21' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN 

UPDATE store_booking  SET status = 'CANCEL' WHERE create_date < date_sub(now(),interval 24 hour);

END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
