-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `products`;
CREATE DATABASE `products` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `products`;

DROP TABLE IF EXISTS `product_info`;
CREATE TABLE `product_info` (
  `productid` int NOT NULL AUTO_INCREMENT,
  `title` varchar(35) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` double(10,2) NOT NULL,
  `shipper` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `recyclable` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `product_info` (`productid`, `title`, `description`, `price`, `shipper`, `weight`, `recyclable`) VALUES
(1,	'Test',	'A creative description.',	0.99,	NULL,	NULL,	NULL),
(2,	'Shovel',	'The classic spade.',	5.99,	'Joe Tools',	5.25,	NULL),
(3,	'Gardening Shovel',	'A small shovel with a curved point.',	3.99,	'Joe Tools',	2.50,	NULL),
(12,	'Arduino',	'A programmable microcontroller.',	23.00,	NULL,	NULL,	'0'),
(13,	'Shampoo',	'A gel used to clean hair.',	2.50,	NULL,	NULL,	NULL),
(16,	'Arduino',	'A programmable microcontroller.',	23.00,	NULL,	NULL,	'1'),
(17,	'Blinker PCB',	'A printed circuit board with a blinking led.',	2.50,	NULL,	NULL,	'0'),
(18,	'Pliers',	'A tool used to grip an object with great force.',	12.00,	'Advanced Grips',	1.10,	NULL),
(19,	'Stool',	'An average, wooden stool.',	7.50,	NULL,	NULL,	NULL),
(20,	'Wrench',	'A stainless steel bolt and nut remover.',	5.67,	'Joe Tools',	3.00,	NULL),
(21,	'AA Battery',	'A standard 1.5 V AA battery cell.',	0.75,	NULL,	NULL,	'0')
ON DUPLICATE KEY UPDATE `productid` = VALUES(`productid`), `title` = VALUES(`title`), `description` = VALUES(`description`), `price` = VALUES(`price`), `shipper` = VALUES(`shipper`), `weight` = VALUES(`weight`), `recyclable` = VALUES(`recyclable`);

-- 2020-04-16 03:41:51
