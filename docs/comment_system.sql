-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 26, 2023 at 12:38 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`) VALUES
(1, 'Website Admin', 'hbahonar', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text NOT NULL,
  `user_email` text,
  `user_name` text,
  `date` datetime NOT NULL,
  `parent_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `comment`, `user_email`, `user_name`, `date`, `parent_id`, `status`, `admin_id`, `post_id`) VALUES
(1, 'This is a comment level 1 1.', 'email@email.com', 'Website User 1', '2023-01-24 09:57:11', 0, 1, NULL, 1),
(2, 'This is a comment level 2 1.', NULL, NULL, '2023-01-24 09:58:36', 1, 1, 1, 1),
(3, 'This is a comment level 3 1.', 'dsfasdfdg', 'Website User 2', '2023-01-25 09:59:59', 2, 1, NULL, 1),
(4, 'This is a comment level 2 2.', 'email@email.com', 'Website User 1', '2023-02-26 06:09:49', 1, 1, NULL, 1),
(5, 'This is a comment level 1 2.', 'email@email.com', 'Website User 1', '2023-02-26 06:19:49', 0, 1, NULL, 1),
(6, 'This is a comment level 3 1.', NULL, NULL, '2023-02-26 09:45:34', 4, 0, 1, 1),
(7, 'This is a comment level 4 1.', 'fsdafdsf', 'Website User 3', '2023-02-26 09:45:48', 3, 0, NULL, 1),
(8, 'This is a comment level 4 2.', 'gadfgdfg', 'Website User 1', '2023-02-26 09:47:37', 3, 0, NULL, 1),
(9, 'This is a comment level 1 3.', 'ewrqewetwe', 'Website User 2', '2023-02-26 09:50:13', 0, 0, NULL, 1),
(10, 'This is a comment level 2 1.', 'uiouioiopoip', 'Website User 3', '2023-02-26 09:50:25', 9, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text,
  `thumbnail` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `thumbnail`) VALUES
(1, 'The Music', 'Music is generally defined as the art of arranging sound to create some combination of form, harmony, melody, rhythm or otherwise expressive content. Exact definitions of music vary considerably around the world, though it is an aspect of all human societies, a cultural universal. While scholars agree that music is defined by a few specific elements, there is no consensus on their precise definitions. The creation of music is commonly divided into musical composition, musical improvisation, and musical performance, though the topic itself extends into academic disciplines, criticism, philosophy, and psychology. Music may be performed or improvised using a vast range of instruments, including the human voice. ', 'https://c.pxhere.com/photos/a8/23/piano_music_score_music_sheet_keyboard_piano_keys_music_musical_instrument-496448.jpg!d');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
