/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : markets

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-01-09 22:25:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for markets
-- ----------------------------
DROP TABLE IF EXISTS `markets`;
CREATE TABLE `markets` (
  `markets_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `map_img` text NOT NULL,
  `userId` int(11) NOT NULL,
  `description` text NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`markets_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of markets
-- ----------------------------
INSERT INTO `markets` VALUES ('24', 'จตุจักร', 'uploads/1514782329map.jpg', '1', 'ตลาดนัด จตุจักร', '2018-01-01 20:59:23');
INSERT INTO `markets` VALUES ('31', 'เจเจ', 'uploads/1514815798map.jpg', '1', '', '2018-01-01 21:09:58');
INSERT INTO `markets` VALUES ('32', 'Jatujak Park Market', 'uploads/1514815851map.jpg', '2', 'เปิดทุกวันหยุดนะคะ', '2018-01-03 22:20:20');
INSERT INTO `markets` VALUES ('34', 'เจเจกรีน', 'uploads/1514816004map.jpg', '2', 'หฟกหก', '2018-01-02 09:08:37');
INSERT INTO `markets` VALUES ('35', 'T', 'uploads/1514862187map.jpg', '2', '', '2018-01-02 10:03:06');
INSERT INTO `markets` VALUES ('36', 'จตุกจักร 2 หมอชิต', 'uploads/1515511015map.jpg', '2', 'มาคร้า', '2018-01-09 22:16:54');

-- ----------------------------
-- Table structure for markets_img
-- ----------------------------
DROP TABLE IF EXISTS `markets_img`;
CREATE TABLE `markets_img` (
  `markets_img_id` int(11) NOT NULL AUTO_INCREMENT,
  `img_url` text NOT NULL,
  `market_id` int(11) NOT NULL,
  PRIMARY KEY (`markets_img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of markets_img
-- ----------------------------
INSERT INTO `markets_img` VALUES ('4', 'uploads/1513751848.jpg', '11');
INSERT INTO `markets_img` VALUES ('5', 'uploads/1513752248.jpg', '12');
INSERT INTO `markets_img` VALUES ('6', 'uploads/1513752276.jpg', '13');
INSERT INTO `markets_img` VALUES ('7', 'uploads/1513752281.jpg', '14');
INSERT INTO `markets_img` VALUES ('8', 'uploads/1513752681.jpg', '15');
INSERT INTO `markets_img` VALUES ('9', 'uploads/1513752725.jpg', '16');
INSERT INTO `markets_img` VALUES ('10', 'uploads/1513753107.jpg', '17');
INSERT INTO `markets_img` VALUES ('11', 'uploads/1513753122.jpg', '18');
INSERT INTO `markets_img` VALUES ('12', 'uploads/1513753135.jpg', '19');
INSERT INTO `markets_img` VALUES ('13', 'uploads/1513840517.jpg', '20');
INSERT INTO `markets_img` VALUES ('14', 'uploads/1513913505.jpg', '21');
INSERT INTO `markets_img` VALUES ('15', 'uploads/1513914041.jpg', '22');
INSERT INTO `markets_img` VALUES ('16', 'uploads/1513914121.jpg', '23');
INSERT INTO `markets_img` VALUES ('17', 'uploads/1514815163.jpg', '24');
INSERT INTO `markets_img` VALUES ('18', 'uploads/1514641873.jpg', '29');
INSERT INTO `markets_img` VALUES ('19', 'uploads/1514642217.jpg', '30');
INSERT INTO `markets_img` VALUES ('20', 'uploads/1514815798.jpg', '31');
INSERT INTO `markets_img` VALUES ('21', 'uploads/1514861744.jpg', '32');
INSERT INTO `markets_img` VALUES ('22', 'uploads/1514815987.jpg', '33');
INSERT INTO `markets_img` VALUES ('23', 'uploads/1514816004.jpg', '34');
INSERT INTO `markets_img` VALUES ('24', 'uploads/1514862187.jpg', '35');
INSERT INTO `markets_img` VALUES ('25', 'uploads/1515511015.jpg', '36');

-- ----------------------------
-- Table structure for markets_type
-- ----------------------------
DROP TABLE IF EXISTS `markets_type`;
CREATE TABLE `markets_type` (
  `markets_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `market_type_name` varchar(50) NOT NULL,
  PRIMARY KEY (`markets_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of markets_type
-- ----------------------------
INSERT INTO `markets_type` VALUES ('1', 'รายวัน');
INSERT INTO `markets_type` VALUES ('2', 'รายเดือน');
INSERT INTO `markets_type` VALUES ('3', 'รายปี');

-- ----------------------------
-- Table structure for market_store
-- ----------------------------
DROP TABLE IF EXISTS `market_store`;
CREATE TABLE `market_store` (
  `store_market_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `markets_id` int(11) NOT NULL,
  `pointX` text NOT NULL,
  `pointY` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  `water_price_per_unit` float NOT NULL,
  `eletric_price_per_unit` float NOT NULL,
  PRIMARY KEY (`store_market_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of market_store
-- ----------------------------
INSERT INTO `market_store` VALUES ('27', '', '1', '24', '42.90591805766313', '51.44375646460156', 'AVAILABLE', '150', '', '0', '0');
INSERT INTO `market_store` VALUES ('31', '', '1', '24', '36.83611532625189', '49.69619785858537', 'AVAILABLE', '1500', '', '0', '0');
INSERT INTO `market_store` VALUES ('32', '', '2', '24', '52.69347496206373', '48.931640968453294', 'AVAILABLE', '3500', '', '0', '0');
INSERT INTO `market_store` VALUES ('33', '', '1', '24', '49.12746585735964', '49.259308207081325', 'AVAILABLE', '150', '', '0', '0');
INSERT INTO `market_store` VALUES ('35', 'ซอย 899999', '1', '32', '47.365153814319214', '50.81787184523089', 'AVAILABLE', '150', '', '0', '0');
INSERT INTO `market_store` VALUES ('36', 'ซอย 8898988', '1', '32', '47.610015174506835', '50.77250982215579', 'AVAILABLE', '150', '', '0', '0');
INSERT INTO `market_store` VALUES ('37', 'ซอย 8', '2', '32', '47.823406676783', '50.76072828948087', 'AVAILABLE', '1500', '', '20', '7');
INSERT INTO `market_store` VALUES ('38', 'ซอย8', '1', '32', '47.989377845220034', '50.73342289502713', 'AVAILABLE', '120', '', '0', '0');
INSERT INTO `market_store` VALUES ('41', 'ซอย 9', '1', '32', '51.17602427921093', '47.83941683969317', 'AVAILABLE', '150', '', '20', '7');
INSERT INTO `market_store` VALUES ('42', 'o', '1', '32', '48.193285280728375', '50.77438098670773', 'AVAILABLE', '150', '', '10', '7');
INSERT INTO `market_store` VALUES ('43', 'kbank', '1', '36', '47.23065250379362', '45.3273013435449', 'AVAILABLE', '150', '-', '10', '7');

-- ----------------------------
-- Table structure for store_booking
-- ----------------------------
DROP TABLE IF EXISTS `store_booking`;
CREATE TABLE `store_booking` (
  `store_booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`store_booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_booking
-- ----------------------------
INSERT INTO `store_booking` VALUES ('8', '2', '2018-01-09 20:14:38', 'WAIT');
INSERT INTO `store_booking` VALUES ('9', '2', '2018-01-09 21:13:11', 'WAIT');
INSERT INTO `store_booking` VALUES ('10', '2', '2018-01-09 21:16:21', 'WAIT');
INSERT INTO `store_booking` VALUES ('11', '2', '2018-01-09 21:28:28', 'WAIT');
INSERT INTO `store_booking` VALUES ('12', '2', '2018-01-09 22:18:54', 'WAIT');

-- ----------------------------
-- Table structure for store_booking_detail
-- ----------------------------
DROP TABLE IF EXISTS `store_booking_detail`;
CREATE TABLE `store_booking_detail` (
  `store_booking_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `water_price_per_unit` float NOT NULL,
  `eletric_price_per_unit` float NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`store_booking_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_booking_detail
-- ----------------------------
INSERT INTO `store_booking_detail` VALUES ('3', '8', '31', '0', '0', '0', '2018-01-09', '2018-01-12');
INSERT INTO `store_booking_detail` VALUES ('4', '9', '31', '0', '0', '0', '2018-01-09', '2018-01-09');
INSERT INTO `store_booking_detail` VALUES ('5', '10', '27', '0', '0', '0', '2018-01-09', '2018-01-09');
INSERT INTO `store_booking_detail` VALUES ('6', '11', '33', '0', '0', '0', '2018-01-09', '2018-01-09');
INSERT INTO `store_booking_detail` VALUES ('7', '12', '43', '0', '0', '0', '2018-01-09', '2018-01-19');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `id_card` varchar(13) NOT NULL,
  `type` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'yy', '2fb1c5cf58867b5bbc9a1b145a86f3a0', 'yyy', 'yyy', '4545345345', '', 'MERCHANT', 'USER');
INSERT INTO `users` VALUES ('2', 'k1', '225bc7ac4aaa1e606a628e990fe2d398', 'panya', 'n', '0859827882', '', 'MERCHANT', 'USER');
INSERT INTO `users` VALUES ('3', 'k2', '225bc7ac4aaa1e606a628e990fe2d398', 'qq', 'qq', '0859827882', '', 'MERCHANT', 'USER');
INSERT INTO `users` VALUES ('4', 'k3', '225bc7ac4aaa1e606a628e990fe2d398', 'k3', 'wewqe', '0859827882', '1251514444545', 'MERCHANT', 'USER');
INSERT INTO `users` VALUES ('5', 'k5', '225bc7ac4aaa1e606a628e990fe2d398', 'k5', 'qwe', '657676', '67567', 'MARKET', 'USER');
