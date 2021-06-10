-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `projects`;
CREATE DATABASE `projects` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projects`;

DROP TABLE IF EXISTS `madlibs`;
CREATE TABLE `madlibs` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `noun` varchar(100) NOT NULL,
  `verb` varchar(100) NOT NULL,
  `adverb` varchar(100) NOT NULL,
  `adjective` varchar(100) NOT NULL,
  `story` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `madlibs` (`userID`, `noun`, `verb`, `adverb`, `adjective`, `story`) VALUES
(10,	'Apple',	'Jump',	'Silently',	'Round',	'You enter a Round classroom with lots of desks and chairs. On one of the desks, you see a Apple that is Silently  shuffling papers. The Apple slowly spins towards you as if it is aware of your presence. The Apple comes to a halt to face you. Creeped out, you Jump and get the heck out of there.'),
(11,	'Battery',	'Cry',	'Hourly',	'Sad',	'You enter a Sad classroom with lots of desks and chairs. On one of the desks, you see a Battery that is Hourly  shuffling papers. The Battery slowly spins towards you as if it is aware of your presence. The Battery comes to a halt to face you. Creeped out, you Cry and get the heck out of there.'),
(12,	'Lamp',	'Look',	'Deathly',	'Bored',	'You enter a Bored classroom with lots of desks and chairs. On one of the desks, you see a Lamp that is Deathly  shuffling papers. The Lamp slowly spins towards you as if it is aware of your presence. The Lamp comes to a halt to face you. Creeped out, you Look and get the heck out of there.'),
(13,	'Pencil',	'Roll',	'Outwardly',	'Stiff',	'You enter a Stiff classroom with lots of desks and chairs. On one of the desks, you see a Pencil that is Outwardly  shuffling papers. The Pencil slowly spins towards you as if it is aware of your presence. The Pencil comes to a halt to face you. Creeped out, you Roll and get the heck out of there.'),
(14,	'Platypus',	'flying',	'fuzzy',	'forlornly',	'You enter a forlornly classroom with lots of desks and chairs. On one of the desks, you see a Platypus that is fuzzy  shuffling papers. The Platypus slowly spins towards you as if it is aware of your presence. The Platypus comes to a halt to face you. Creeped out, you flying and get the heck out of there.'),
(15,	'object',	'concatenated',	'whistling',	'green',	'You enter a green classroom with lots of desks and chairs. On one of the desks, you see a object that is whistling  shuffling papers. The object slowly spins towards you as if it is aware of your presence. The object comes to a halt to face you. Creeped out, you concatenated and get the heck out of there.'),
(20,	'world',	'swirls',	'unknowingly',	'circular',	'You enter a circular classroom with lots of desks and chairs. On one of the desks, you see a world that is unknowingly  shuffling papers. The world slowly spins towards you as if it is aware of your presence. The world comes to a halt to face you. Creeped out, you swirls and get the heck out of there.'),
(21,	'bird',	'blink',	'curiously',	'infected',	'You enter a infected classroom with lots of desks and chairs. On one of the desks, you see a bird that is curiously  shuffling papers. The bird slowly spins towards you as if it is aware of your presence. The bird comes to a halt to face you. Creeped out, you blink and get the heck out of there.'),
(41,	'raindrop',	'fall',	'randomly',	'sticky',	'You enter a sticky classroom with lots of desks and chairs. On one of the desks, you see a raindrop that is randomly  shuffling papers. The raindrop slowly spins towards you as if it is aware of your presence. The raindrop comes to a halt to face you. Creeped out, you fall and get the heck out of there.'),
(42,	'bouncy ball',	'roll',	'sheepishly',	'obnoxiously',	'You enter a obnoxiously classroom with lots of desks and chairs. On one of the desks, you see a bouncy ball that is sheepishly  shuffling papers. The bouncy ball slowly spins towards you as if it is aware of your presence. The bouncy ball comes to a halt to face you. Creeped out, you roll and get the heck out of there.')
ON DUPLICATE KEY UPDATE `userID` = VALUES(`userID`), `noun` = VALUES(`noun`), `verb` = VALUES(`verb`), `adverb` = VALUES(`adverb`), `adjective` = VALUES(`adjective`), `story` = VALUES(`story`);

-- 2020-04-13 03:07:23
