-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `projects`;
CREATE DATABASE `projects` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projects`;

DROP TABLE IF EXISTS `exercise_log`;
CREATE TABLE `exercise_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `type` varchar(32) NOT NULL,
  `time_in_minutes` int NOT NULL,
  `heartrate` int NOT NULL,
  `calories` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `exercise_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `exercise_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `exercise_log` (`id`, `user_id`, `date`, `type`, `time_in_minutes`, `heartrate`, `calories`) VALUES
(2,	3,	'2020-04-04',	'running',	30,	160,	510),
(3,	3,	'2020-04-01',	'swimming',	60,	158,	1002),
(4,	3,	'2020-04-02',	'swimming',	90,	163,	1571),
(5,	3,	'2020-03-18',	'weightlifting',	15,	175,	289),
(6,	3,	'2020-03-19',	'walking',	60,	120,	658),
(7,	3,	'2020-03-17',	'swimming',	60,	163,	1048),
(8,	3,	'2020-03-15',	'biking',	53,	168,	965),
(9,	3,	'2020-03-13',	'swimming',	36,	160,	612),
(10,	3,	'2020-03-12',	'biking',	55,	169,	1010),
(11,	3,	'2020-03-11',	'yoga',	30,	120,	329),
(12,	3,	'2020-03-10',	'swimming',	75,	178,	1479),
(13,	3,	'2020-03-09',	'swimming',	90,	163,	1571),
(14,	3,	'2020-03-08',	'walking',	90,	135,	1191),
(15,	3,	'2020-03-07',	'biking',	30,	100,	239),
(16,	3,	'2020-03-05',	'weightlifting',	30,	100,	239),
(17,	3,	'2020-03-03',	'swimming',	60,	150,	930),
(20,	4,	'2020-04-04',	'running',	30,	160,	328),
(21,	4,	'2020-04-03',	'other',	60,	120,	400),
(22,	10,	'2020-04-04',	'biking',	60,	120,	634);

DROP TABLE IF EXISTS `exercise_user`;
CREATE TABLE `exercise_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `first_name` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_name` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `weight` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `exercise_user` (`id`, `username`, `password`, `first_name`, `last_name`, `gender`, `birthdate`, `weight`) VALUES
(1,	'bobbyj123',	'5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8',	'Bob',	'Jones',	'm',	'1970-01-01',	225),
(3,	'jnettles',	'cbfdac6008f9cab4083784cbd1874f76618d2a97',	'John',	'Nettles',	'm',	'1975-05-05',	180),
(4,	'jane',	'40bd001563085fc35165329ea1ff5c5ecbdbbeef',	'Jane',	'Doe',	'f',	'1976-03-27',	150),
(5,	'billybob1890',	'a03a4beb26e0f5e3770e22bf4bc0efcf91ca77cb',	NULL,	NULL,	NULL,	NULL,	NULL),
(6,	'jnettles2',	'a9993e364706816aba3e25717850c26c9cd0d89d',	NULL,	NULL,	'm',	'1980-03-31',	150),
(7,	'egg',	'8cb2237d0679ca88db6464eac60da96345513964',	'Jack',	'Smith',	'm',	'1988-05-05',	225),
(10,	'john314',	'5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8',	'John',	'Smith',	'm',	'1970-01-01',	150);

-- 2020-04-04 18:57:48
