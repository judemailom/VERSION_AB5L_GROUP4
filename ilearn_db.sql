-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 17, 2013 at 06:38 AM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_question`(_question_id INT(64), _test_id INT(64), _question VARCHAR(64), _choice_a VARCHAR(64), _choice_b VARCHAR(64), _choice_c VARCHAR(64), _choice_d VARCHAR(64), _correct_answer ENUM('A', 'B', 'C', 'D'), _item_number INT(64))
BEGIN
	INSERT INTO question VALUES(_question_id, _test_id, _question, _choice_a, _choice_b, _choice_c, _choice_d, _correct_answer, _item_number);
	SELECT last_insert_id();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_test`(_id INT(64), _title VARCHAR(64), _author_id INT(64), _test_length INT(64), _test_status ENUM('FINISHED', 'UNFINISHED'), _test_date_uploaded TIMESTAMP, _test_date_finished TIMESTAMP)
BEGIN
	INSERT INTO test VALUES(_id, _title, _author_id, _test_length, _test_status, _test_date_uploaded, _test_date_finished);
	SELECT last_insert_id();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_test_classlist`(_test_id INT(64), _classlist_name VARCHAR(64))
BEGIN
	INSERT INTO test_classlist VALUES(_test_id, (SELECT classlist_id FROM classlist WHERE classlist_name = _classlist_name));
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_finished_tests`(_user_id INT(64))
BEGIN
	SELECT * FROM test WHERE test_status = "FINISHED" AND test_id IN (SELECT test_id FROM test_classlist WHERE classlist_id IN (SELECT classlist_id FROM classlist_members WHERE classlist_user_id = _user_id));
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_unfinished_tests`(_user_id INT(64))
BEGIN
	SELECT * FROM test WHERE test_status = "UNFINISHED" AND test_id IN (SELECT test_id FROM test_classlist WHERE classlist_id IN (SELECT classlist_id FROM classlist_members WHERE classlist_user_id = _user_id));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(50) NOT NULL,
  `admin_comp` varchar(50) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

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
-- Table structure for table `classlist`
--

CREATE TABLE IF NOT EXISTS `classlist` (
  `classlist_id` int(64) NOT NULL AUTO_INCREMENT,
  `classlist_name` varchar(64) NOT NULL,
  `classlist_author_id` int(64) NOT NULL,
  PRIMARY KEY (`classlist_id`),
  KEY `classlist_author_id` (`classlist_author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `classlist`
--

INSERT INTO `classlist` (`classlist_id`, `classlist_name`, `classlist_author_id`) VALUES
(1, 'MATH17', 33),
(2, 'SPCM1', 13),
(3, 'CMSC125', 13),
(4, 'NASC2', 33);

-- --------------------------------------------------------

--
-- Table structure for table `classlist_members`
--

CREATE TABLE IF NOT EXISTS `classlist_members` (
  `classlist_id` int(64) NOT NULL,
  `classlist_user_id` int(64) NOT NULL,
  KEY `classlist_id` (`classlist_id`,`classlist_user_id`),
  KEY `classlist_user_id` (`classlist_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classlist_members`
--

INSERT INTO `classlist_members` (`classlist_id`, `classlist_user_id`) VALUES
(1, 8),
(1, 11),
(1, 13),
(1, 29),
(1, 34),
(2, 11),
(2, 12),
(2, 34),
(3, 12),
(3, 31),
(3, 34),
(4, 34);

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
  `forum_id` int(64) NOT NULL AUTO_INCREMENT,
  `forum_name` varchar(64) NOT NULL,
  `forum_description` varchar(64) NOT NULL,
  `forum_author_id` int(64) NOT NULL,
  PRIMARY KEY (`forum_id`),
  KEY `forum_author_id` (`forum_author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_members`
--

CREATE TABLE IF NOT EXISTS `forum_members` (
  `forum_id` int(64) NOT NULL,
  `forum_user_id` int(64) NOT NULL,
  KEY `forum_id` (`forum_id`,`forum_user_id`),
  KEY `forum_user_id` (`forum_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(64) NOT NULL AUTO_INCREMENT,
  `test_id` int(64) NOT NULL,
  `question` varchar(64) NOT NULL,
  `test_choice_a` varchar(64) NOT NULL,
  `test_choice_b` varchar(64) NOT NULL,
  `test_choice_c` varchar(64) NOT NULL,
  `test_choice_d` varchar(64) NOT NULL,
  `test_correct_answer` enum('A','B','C','D') NOT NULL,
  `test_item_number` int(64) NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `test_id` (`test_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `test_id`, `question`, `test_choice_a`, `test_choice_b`, `test_choice_c`, `test_choice_d`, `test_correct_answer`, `test_item_number`) VALUES
(22, 93, 'question 1', 'jhkjh', 'hkjhj', 'hkh', 'kjh', 'A', 1),
(23, 93, 'question 2', 'kjlkjlkjk', 'jlk', 'jlj', 'klj', 'A', 2),
(24, 94, 'first question', 'first choice', 'second choice', 'third choice', 'fourth choice', 'C', 1),
(25, 94, 'second question', 'choice a', 'choice b', 'choice c', 'choice D', 'A', 2),
(26, 94, 'other question', 'who', 'what', 'when ', 'where', 'A', 3),
(27, 94, 'isa pang katanungan', 'isa', 'dalawa', 'tatlo', 'apat', 'C', 4),
(28, 94, 'hurray', 'huzzah', 'yahoo', 'yehey', 'magdiwang', 'D', 5),
(29, 95, 'dfsdhkj', 'jbkj', 'jb', 'b', 'jbj', 'A', 1),
(30, 96, 'mkldnkhiu', 'bdf,sdfnjk', 'jhgv', 'hjvj', 'mnb', 'A', 1),
(31, 97, '', '', '', '', '', 'A', 1),
(32, 98, 'First Question', 'CHOICE A', 'CHOICE B', 'CHOICE C', 'CHOICE D', 'C', 1),
(33, 98, 'Second Question', 'A', 'bkjbkj', 'C', 'D', 'C', 2),
(34, 98, 'Another question', 'k', 'hjhhgvht', 'oiuio', 'gjhg', 'A', 3),
(35, 99, 'ISANG TANONG', 'ISANG SAGOT', 'DALAWANG SAGOT', 'TATLONG SAGOT', 'WALANG SAGOT', 'C', 1),
(36, 99, 'ISA PANG TANONG ULIT', 'ISANG SAGOT ULIT', 'DALAWANG SAGOT ULIT', 'TATLOG SAGOT ULIT', 'WALA ULIT SAGOT BAGSAK NA!', 'D', 2),
(37, 100, 'sdsdsf', 'hkhj', 'hkhkj', 'hkjhkj', 'hkjhk', 'A', 1);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

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
(34, 'SCHOOL1', 2),
(36, 'SCHOOL1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

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
(33, 'teacher', 'SCHOOL2'),
(35, 'dept', 'SCHOOL4');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `test_id` int(64) NOT NULL AUTO_INCREMENT,
  `test_name` varchar(64) NOT NULL,
  `test_author_id` int(64) NOT NULL,
  `test_length` int(64) NOT NULL,
  `test_status` enum('FINISHED','UNFINISHED') NOT NULL,
  `test_date_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `test_date_deadline` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`test_id`),
  KEY `test_author_id` (`test_author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `test_name`, `test_author_id`, `test_length`, `test_status`, `test_date_upload`, `test_date_deadline`) VALUES
(93, 'dkjsahkjhk', 33, 2, 'UNFINISHED', '2013-02-10 16:00:00', '2013-02-14 16:00:00'),
(94, 'another test', 33, 5, 'UNFINISHED', '2013-02-10 16:00:00', '2013-02-21 16:00:00'),
(95, 'jlknjjhcghc', 33, 1, 'UNFINISHED', '2013-02-10 16:00:00', '2013-02-20 16:00:00'),
(96, 'nkj', 33, 1, 'UNFINISHED', '2013-02-10 16:00:00', '2013-02-14 16:00:00'),
(97, '1st Long Exam MATH17', 33, 1, 'UNFINISHED', '2013-02-11 16:00:00', '2013-02-20 16:00:00'),
(98, 'First long exam NASC2', 33, 3, 'UNFINISHED', '2013-02-11 16:00:00', '2013-02-12 16:00:00'),
(99, 'TEST NA MAHIRAP', 33, 2, 'UNFINISHED', '2013-02-11 16:00:00', '2013-02-13 16:00:00'),
(100, 'HARD TEST', 33, 1, 'UNFINISHED', '2013-02-15 16:00:00', '2013-02-17 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `test_classlist`
--

CREATE TABLE IF NOT EXISTS `test_classlist` (
  `test_id` int(64) NOT NULL,
  `classlist_id` int(64) NOT NULL,
  KEY `test_id` (`test_id`,`classlist_id`),
  KEY `classlist_id` (`classlist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_classlist`
--

INSERT INTO `test_classlist` (`test_id`, `classlist_id`) VALUES
(93, 1),
(93, 4),
(94, 1),
(94, 4),
(96, 1),
(97, 1),
(99, 1),
(99, 4),
(100, 1),
(100, 4);

-- --------------------------------------------------------

--
-- Table structure for table `test_question`
--

CREATE TABLE IF NOT EXISTS `test_question` (
  `test_id` int(64) NOT NULL,
  `question_id` int(64) NOT NULL,
  KEY `test_id` (`test_id`,`question_id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_question`
--

INSERT INTO `test_question` (`test_id`, `question_id`) VALUES
(86, 0),
(87, 0),
(87, 0),
(90, 0),
(90, 0),
(91, 0),
(92, 0),
(93, 22),
(93, 23),
(94, 24),
(94, 25),
(94, 26),
(94, 27),
(94, 28),
(95, 29),
(96, 30),
(97, 31),
(98, 32),
(98, 33),
(98, 34),
(99, 35),
(99, 36),
(100, 37);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `user_uname` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_fname` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

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
(33, 'teacher', '8d788385431273d11e8b43bb78f3aa41', 'FIRST NAME LAST NAME', 'Teacher'),
(34, 'student', 'cd73502828457d15655bbd7a63fb0bc8', 'student student', 'Student'),
(35, 'teacher1', '41c8949aa55b8cb5dbec662f34b62df3', 'tester tester', 'Teacher'),
(36, 'julianaseneta', '5d7845ac6ee7cfffafc5fe5f35cf666d', 'Allen Mailom', 'Student');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classlist`
--
ALTER TABLE `classlist`
  ADD CONSTRAINT `classlist_ibfk_1` FOREIGN KEY (`classlist_author_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classlist_members`
--
ALTER TABLE `classlist_members`
  ADD CONSTRAINT `classlist_members_ibfk_1` FOREIGN KEY (`classlist_id`) REFERENCES `classlist` (`classlist_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classlist_members_ibfk_2` FOREIGN KEY (`classlist_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`forum_author_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forum_members`
--
ALTER TABLE `forum_members`
  ADD CONSTRAINT `forum_members_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `forum_members_ibfk_2` FOREIGN KEY (`forum_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `test` (`test_id`) ON DELETE CASCADE;

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`test_author_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test_classlist`
--
ALTER TABLE `test_classlist`
  ADD CONSTRAINT `test_classlist_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `test` (`test_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `test_classlist_ibfk_2` FOREIGN KEY (`classlist_id`) REFERENCES `classlist` (`classlist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
