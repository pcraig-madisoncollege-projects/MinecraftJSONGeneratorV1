-- Adminer 4.7.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `aliens_abduction`;
CREATE TABLE `aliens_abduction` (
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `when_it_happened` varchar(30) DEFAULT NULL,
  `how_long` varchar(30) DEFAULT NULL,
  `how_many` varchar(30) DEFAULT NULL,
  `alien_description` varchar(100) DEFAULT NULL,
  `what_they_did` varchar(100) DEFAULT NULL,
  `fang_spotted` varchar(10) DEFAULT NULL,
  `other` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `aliens_abduction` (`first_name`, `last_name`, `when_it_happened`, `how_long`, `how_many`, `alien_description`, `what_they_did`, `fang_spotted`, `other`, `email`) VALUES
('Sally',	'Jones',	'3 days ago',	'1 day',	'four',	'green with six tentacles',	'We just talked and played with a dog',	'yes',	'I may have seen your dog. Contact me.',	'sally@gregs-list.net'),
('Peter',	'Craig',	'never',	'not long at all',	'0',	'nonexistent',	'nothing',	'no',	'Nope',	'pjcraig@madisoncollege.edu'),
('Peter',	'Craig',	'never',	'not long at all',	'0',	'nonexistent',	'nothing',	'no',	'Nope',	'pjcraig@madisoncollege.edu'),
('Peter',	'Craig',	'never',	'not long at all',	'0',	'nonexistent',	'nothing',	'no',	'Nope',	'pjcraig@madisoncollege.edu'),
('Peter',	'Craig',	'never',	'not long at all',	'0',	'nonexistent',	'nothing',	'no',	'Nope',	'pjcraig@madisoncollege.edu'),
('Billy',	'Jones',	'3 days ago',	'1 day',	'four',	'green with six tentacles',	'We just talked and played with a dog',	'yes',	'I may have seen your dog. Contact me.',	'sally@gregs-list.net'),
('John',	'Smith',	'5 days ago',	'12 hours',	'1',	'big blue beasts',	'inspected and questioned me',	'yes',	'Fang may have been assisting in their capture of me',	'johnsmith@example.com');

-- 2020-02-01 01:19:09
