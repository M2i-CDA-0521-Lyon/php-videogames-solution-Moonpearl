-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `videogames`;
CREATE DATABASE `videogames` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `videogames`;

DROP TABLE IF EXISTS `developer`;
CREATE TABLE `developer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `developer` (`id`, `name`, `link`) VALUES
(1,	'Bullfrog Productions',	'https://en.wikipedia.org/wiki/Bullfrog_Productions'),
(2,	'id Software',	'https://en.wikipedia.org/wiki/Id_Software'),
(3,	'LucasArts',	'https://en.wikipedia.org/wiki/LucasArts'),
(4,	'tri-Ace',	'https://en.wikipedia.org/wiki/Tri-Ace'),
(5,	'Nintendo',	'https://en.wikipedia.org/wiki/Nintendo');

DROP TABLE IF EXISTS `platform`;
CREATE TABLE `platform` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `platform` (`id`, `name`, `link`) VALUES
(1,	'SNES',	'https://en.wikipedia.org/wiki/Super_Nintendo_Entertainment_System'),
(2,	'MS-DOS',	'https://en.wikipedia.org/wiki/MS-DOS'),
(3,	'Amiga',	'https://en.wikipedia.org/wiki/Amiga'),
(4,	'PlayStation',	'https://en.wikipedia.org/wiki/PlayStation'),
(5,	'Windows',	'https://en.wikipedia.org/wiki/Microsoft_Windows');

DROP TABLE IF EXISTS `game`;
CREATE TABLE `game` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `link` varchar(255) NOT NULL,
  `developer_id` int(10) unsigned NOT NULL,
  `platform_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_game_developer_id` (`developer_id`),
  KEY `fk_game_platform_id` (`platform_id`),
  CONSTRAINT `fk_game_developer_id` FOREIGN KEY (`developer_id`) REFERENCES `developer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_game_platform_id` FOREIGN KEY (`platform_id`) REFERENCES `platform` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

INSERT INTO `game` (`id`, `title`, `release_date`, `link`, `developer_id`, `platform_id`) VALUES
(1,	'Populous',	'1989-06-05',	'https://en.wikipedia.org/wiki/Populous_(video_game)',	1,	3),
(2,	'Doom',	'1993-12-10',	'https://en.wikipedia.org/wiki/Doom_(1993_video_game)',	2,	2),
(3,	'Quake',	'1996-06-22',	'https://en.wikipedia.org/wiki/Quake_(video_game)',	2,	2),
(4,	'The Secret of Monkey Island',	'1990-10-01',	'https://en.wikipedia.org/wiki/The_Secret_of_Monkey_Island',	3,	3),
(5,	'Day of the Tentacle',	'1993-06-25',	'https://en.wikipedia.org/wiki/Day_of_the_Tentacle',	3,	2),
(6,	'Dungeon Keeper',	'1997-06-26',	'https://en.wikipedia.org/wiki/Dungeon_Keeper',	1,	2),
(7,	'Valkyrie Profile',	'1999-12-22',	'https://en.wikipedia.org/wiki/Valkyrie_Profile',	4,	4),
(8,	'Star Ocean',	'1996-07-19',	'https://en.wikipedia.org/wiki/Star_Ocean_(video_game)',	4,	1),
(9,	'The Legend of Zelda',	'1986-02-21',	'https://en.wikipedia.org/wiki/The_Legend_of_Zelda',	5,	1),
(10,	'Super Mario Bros.',	'1985-09-13',	'https://en.wikipedia.org/wiki/Super_Mario_Bros.',	5,	1);

-- 2020-10-21 17:48:00
