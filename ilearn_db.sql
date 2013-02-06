-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2013 at 08:28 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user` CASCADE;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `user_uname` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_fname` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_uname`, `user_password`, `user_fname`, `user_type`) VALUES
(8, 'asdasd', '4297f44b13955235245b2497399d7a93', 'asd asd', 'Teacher'),
(9, 'lasdlasdla', '32c5a1a483903316fc44900b760b8e6d', 'ads qads', 'Student'),
(10, 'lasdlasdla1', 'a8f5f167f44f4964e6c998dee827110c', 'ads qads', 'Student'),
(11, 'asdasdasd', 'a8f5f167f44f4964e6c998dee827110c', 'hjk jk', 'Student'),
(12, 'judemailom', '22640e56726a08dda37214dcb00cf647', 'judemailom judema', 'Student'),
(13, 'judemailom1', '4297f44b13955235245b2497399d7a93', 'judemailom judema', 'Teacher'),
(24, 'jeanjean', '522e6bf0be8955a0de9531dad8f01ccb', 'kjljklj ljlkjlkjlk', 'Student'),
(29, 'wewewew', 'e564b6df48781a5fdf8ca5263ace1947', 'sdsds dasdsa', 'Teacher'),
(31, 'erwsrsdrsfe', 'bd020cb9276f6d5ceef68d606b3d473b', 'dfsdfsdfsd sadsdasdas', 'Teacher'),
(33, 'teacher', '8d788385431273d11e8b43bb78f3aa41', 'teacher teacher', 'Teacher'),
(34, 'student', 'cd73502828457d15655bbd7a63fb0bc8', 'student student', 'Student');


--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin` CASCADE; 
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(50) NOT NULL,
  `admin_comp` varchar(50) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--
DROP TABLE IF EXISTS `announcement` CASCADE;
CREATE TABLE IF NOT EXISTS `announcement` (
  `announcement_id` int(64) NOT NULL AUTO_INCREMENT,
  `author_id` int(64) NOT NULL,
  `announcement_title` varchar(64) NOT NULL,
  `announcement_content` text NOT NULL,
  PRIMARY KEY (`announcement_id`),
  KEY `author` (`author_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `author_id`, `announcement_title`, `announcement_content`) VALUES
(1, 13, 'Announcement 1', 'This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! This is an announcement! '),
(2, 24, 'This is also an announcement', 'sjdalsdjaskldjlask sjdalsdjaskldjlask sfnlaskdnal ;ad ofh ;sdf klkxjh vlxjvk lxkcjhlxk vhlxckjvh ldvjh sjsdh jfkhsdkjfh lsdkfh jsdlfkjh lskdf sdlk fhdj'),
(3, 8, 'title of an announcement', 'this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. this is an announcement. '),
(4, 31, 'this is also an announcement', 'LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM '),
(5, 8, 'fgdfgsdfgs another announcement', 'hlhjlkjhlkjhlkjh flsdfh sdfh lsdfikh sdlkfh lsdkhf skldjfh sdlkfh djfh skdljfh slkdfjh skldfjh sldfkjh sldkfjh lskdjfh sldkf jhlsdkjf');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school` CASCADE;
CREATE TABLE IF NOT EXISTS `school` (
  `school_id` int(64) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(64) NOT NULL,
  PRIMARY KEY (`school_id`),
  UNIQUE KEY `school_name` (`school_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`school_id`, `school_name`) VALUES
(15, 'SCHOOL1'),
(16, 'SCHOOL2'),
(17, 'SCHOOL3'),
(18, 'SCHOOL4'),
(19, 'SCHOOL5'),
(20, 'SCHOOL6'),
(21, 'SCHOOL7'),
(22, 'SCHOOL8'),
(23, 'SCHOOL9');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student` CASCADE;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(64) NOT NULL,
  `student_school_name` varchar(64) NOT NULL,
  `student_level` int(64) NOT NULL,
  PRIMARY KEY (`student_id`),
  KEY `student_school_name` (`student_school_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_school_name`, `student_level`) VALUES
(9, 'SCHOOL2', 1),
(10, 'SCHOOL4', 3),
(11, 'SCHOOL2', 3),
(12, 'SCHOOL2', 1),
(24, 'SCHOOL2', 2),
(34, 'SCHOOL1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher` CASCADE;
CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` int(64) NOT NULL,
  `teacher_dept` varchar(64) NOT NULL,
  `teacher_school_name` varchar(64) NOT NULL,
  KEY `teacher_id` (`teacher_id`,`teacher_school_name`),
  KEY `teacher_school_name` (`teacher_school_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `teacher_dept`, `teacher_school_name`) VALUES
(8, 'asdasdas', 'SCHOOL2'),
(29, '', 'SCHOOL2'),
(13, 'dsdasd', 'SCHOOL1'),
(31, 'dasa', 'SCHOOL2'),
(33, 'teacher', 'SCHOOL2');

-- --------------------------------------------------------

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`student_school_name`) REFERENCES `school` (`school_name`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_2` FOREIGN KEY (`teacher_school_name`) REFERENCES `school` (`school_name`),
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
