-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2013 at 10:53 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ilearn_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `classlist_member`
--

CREATE TABLE IF NOT EXISTS `classlist_member` (
  `id` int(50) NOT NULL,
  `memberid` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classlist_member`
--

INSERT INTO `classlist_member` (`id`, `memberid`) VALUES
(1, 35);
INSERT INTO `classlist_member` (`id`, `memberid`) VALUES
(1, 9);
INSERT INTO `classlist_member` (`id`, `memberid`) VALUES
(1, 10);
INSERT INTO `classlist_member` (`id`, `memberid`) VALUES
(1, 11);
INSERT INTO `classlist_member` (`id`, `memberid`) VALUES
(1, 12);
INSERT INTO `classlist_member` (`id`, `memberid`) VALUES
(1, 24);
INSERT INTO `classlist_member` (`id`, `memberid`) VALUES
(1, 34);
INSERT INTO `classlist_member` (`id`, `memberid`) VALUES
(1, 35);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classlist_member`
--
ALTER TABLE `classlist_member`
  ADD CONSTRAINT `classlist_member_ibfk_2` FOREIGN KEY (`memberid`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classlist_member_ibfk_1` FOREIGN KEY (`id`) REFERENCES `classlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
