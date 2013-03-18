-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 06, 2013 at 08:20 AM
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
--
USE ilearn_temp;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `classlist`
--

INSERT INTO `classlist` (`classlist_id`, `classlist_name`, `classlist_author_id`) VALUES
(11, 'CMSC22 Section Jude - Classlist', 38),
(12, 'CMSC22 Section Jude - Classlist', 38),
(13, 'CMSC57 Section Julian - Classlist', 41);

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
(11, 37),
(12, 37),
(12, 39),
(12, 40),
(13, 37),
(13, 39),
(13, 40);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `forum_name`, `forum_description`, `forum_author_id`) VALUES
(19, 'Forum ni Jude', 'CMSC22 Students', 38),
(21, 'A forum', 'Nice forum\r\n', 41),
(22, 'FORUM OF JULIAN', 'Mga Julianers lang. ', 41),
(24, 'This is a test forum', 'Forum description', 38),
(25, 'iLEARN Incomplete Functionalities', 'iLEARN Incomplete Functionalities', 38),
(59, 'CMSC 22 Section Jude', 'Exclusive for CMSC22 Students Section Jude only. ', 38);

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

--
-- Dumping data for table `forum_members`
--

INSERT INTO `forum_members` (`forum_id`, `forum_user_id`) VALUES
(19, 39),
(19, 40),
(21, 37),
(21, 38),
(21, 39),
(21, 40),
(22, 37),
(22, 40),
(24, 37),
(24, 39),
(25, 37),
(25, 39),
(25, 40),
(59, 39),
(59, 40);

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE IF NOT EXISTS `forum_posts` (
  `forum_posts_id` int(64) NOT NULL AUTO_INCREMENT,
  `forum_id` int(64) NOT NULL,
  `forum_post_author_id` int(64) NOT NULL,
  `forum_post_date` date NOT NULL,
  `forum_post_content` text NOT NULL,
  PRIMARY KEY (`forum_posts_id`),
  KEY `forum_id` (`forum_id`,`forum_post_author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `forum_posts`
--

INSERT INTO `forum_posts` (`forum_posts_id`, `forum_id`, `forum_post_author_id`, `forum_post_date`, `forum_post_content`) VALUES
(17, 19, 38, '0000-00-00', 'This is a forum for CMSC22 Students. :)'),
(18, 19, 38, '0000-00-00', 'Exam next week. '),
(19, 19, 37, '0000-00-00', 'Complain about the exam. '),
(20, 19, 38, '0000-00-00', 'Comment ulit sa exam'),
(21, 21, 41, '0000-00-00', 'Nag post si Julian'),
(22, 21, 37, '0000-00-00', 'Nag comment si Jean'),
(24, 21, 41, '0000-00-00', 'Another comment'),
(25, 22, 40, '0000-00-00', 'Isang post'),
(26, 19, 38, '0000-00-00', 'The quick brown fox jumps over the lazy dog. '),
(30, 24, 38, '0000-00-00', 'ddsdf'),
(32, 24, 38, '0000-00-00', 'fsfd'),
(33, 24, 38, '0000-00-00', 'dfsdfsd'),
(34, 24, 38, '0000-00-00', 'dsfsdfsd'),
(35, 21, 37, '0000-00-00', 'dfsdfsdfsd'),
(36, 21, 37, '0000-00-00', 'dfsdfsdfsd'),
(37, 21, 37, '0000-00-00', 'This is an example of a comment'),
(38, 21, 37, '0000-00-00', 'Astig, sumusunod na ang view!'),
(39, 25, 38, '0000-00-00', 'Javascript - Add members ng forum: \r\n\r\nDapat disabled ang checkbox kapag enabled na siya sa kabilang classlist. '),
(41, 25, 38, '0000-00-00', 'User Interface - JQuery, Ajax?'),
(42, 25, 38, '0000-00-00', 'Admin functionalities - Lahat'),
(43, 25, 38, '0000-00-00', 'View top scorers'),
(44, 25, 38, '0000-00-00', 'Classlist - Page layout. Minimize clicking'),
(45, 25, 38, '0000-00-00', 'Unique dapat ang user_fname, kung kaya, paghiwalayin ang First Name at Last Name'),
(46, 25, 38, '0000-00-00', 'Classlist - search key /as/ results: Jean ManAS, Julian ASeneta. Searchable kahit parts lang ng string ang given'),
(48, 25, 38, '0000-00-00', 'Bawal ang quotation marks sa comment or kahit anong text field that involves inserting :( '),
(51, 22, 41, '0000-00-00', 'Isa pang post'),
(52, 19, 37, '0000-00-00', 'Another comment'),
(53, 25, 38, '0000-00-00', 'Loading.. (Sign in or sign up), transitions, carousel'),
(58, 21, 37, '0000-00-00', 'fgdfgdfgdf'),
(59, 19, 40, '0000-00-00', 'Test test'),
(60, 21, 41, '0000-00-00', 'Ang comment ni Julian'),
(61, 19, 37, '0000-00-00', 'Another test comment!!'),
(62, 19, 39, '0000-00-00', 'comment commnet'),
(63, 19, 37, '0000-00-00', 'hahahahahha'),
(64, 19, 39, '0000-00-00', 'a long comment a long comment a long comment a long comment a long comment a long comment a long comment a long comment  wikipedia wikipedia wikipedia wikipedia wikipedia wikipedia wikipedia the quick brown fox jumps over the lazy dog  the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog'),
(65, 21, 37, '0000-00-00', 'sfs'),
(66, 21, 37, '0000-00-00', 'sfs'),
(67, 21, 37, '0000-00-00', 'ISA PANG COMMNT\r\n'),
(68, 21, 37, '2013-03-05', 'sdasfsd'),
(69, 21, 37, '2013-03-05', 'ISA PAAA!'),
(70, 19, 38, '2013-03-05', 'ANOTHER COMMENT!!!'),
(72, 21, 41, '2013-03-05', 'ANOTHER ONE'),
(73, 24, 37, '2013-03-06', 'jsdfsdfsd'),
(75, 25, 37, '2013-03-06', 'Classlist - search key /as/ results: Jean ManAS, Julian ASeneta. Searchable kahit parts lang ng string ang given. Gumamit ng LIKE %KEYWORD% sa query.');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(64) NOT NULL AUTO_INCREMENT,
  `test_id` int(64) NOT NULL,
  `question` text NOT NULL,
  `test_choice_a` varchar(64) NOT NULL,
  `test_choice_b` varchar(64) NOT NULL,
  `test_choice_c` varchar(64) NOT NULL,
  `test_choice_d` varchar(64) NOT NULL,
  `test_correct_answer` enum('A','B','C','D') NOT NULL,
  `test_item_number` int(64) NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `test_id` (`test_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `test_id`, `question`, `test_choice_a`, `test_choice_b`, `test_choice_c`, `test_choice_d`, `test_correct_answer`, `test_item_number`) VALUES
(58, 112, 'Which distribution model of counting is identical and non-exclusive?', 'Sequence', 'Permutation', 'Multiset', 'Combination', 'C', 1),
(59, 112, 'Which sample model of counting is done without order and without repetition?', 'Sequence', 'Permutation', 'Multiset', 'Combination', 'D', 2),
(60, 112, 'Which of the following is a permutaion model of two objects from the set {a, b, c}?', '{ab, bc, ac, cb, ca, ba, aa, bb, cc}', '{aa, bb, cc, ab, bc, ca}', '{ab, bc, ac, cb, ca, ba}', 'None of the above', 'C', 3),
(61, 112, 'If k pigeons are assigned to n pigeon holes, then one of the pigeonholes contain at least the following no. of pigeons:', 'ceiling function(k-1/n) + 1', 'ceiling function(k-1/n) - 1', 'floor function(k-1/n) + 1', 'floor function(k-1/n) - 1', 'A', 4),
(62, 112, 'A student wishes to take just one course during the summer term. Offered are thre math courses, four biology courses and five language courses. In how many ways can the student register for the summer term? ', '9', '10', '11', '12', 'D', 5),
(63, 113, 'jkkj', 'jkkjk', 'jk', 'jk', 'jdfdf', 'A', 1),
(68, 118, ' bvgy', 'crt', 'dy', 'fuc', 'v b ', 'A', 1),
(69, 119, 'Question 1', 'Choice A', 'Choice B', 'Choice C', 'Choice D', 'C', 1);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `school_id` int(64) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(64) NOT NULL,
  PRIMARY KEY (`school_id`),
  UNIQUE KEY `school_name` (`school_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`school_id`, `school_name`) VALUES
(24, 'SCHOOL1'),
(25, 'SCHOOL2'),
(26, 'SCHOOL3'),
(27, 'SCHOOL4'),
(28, 'SCHOOL5');

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
(37, 'SCHOOL1', 9),
(39, 'SCHOOL1', 9),
(40, 'SCHOOL1', 9),
(42, 'SCHOOL2', 3),
(43, 'SCHOOL2', 1),
(44, 'SCHOOL2', 2);

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
(38, 'ICS', 'SCHOOL1'),
(41, 'ICS', 'SCHOOL1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=120 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `test_name`, `test_author_id`, `test_length`, `test_status`, `test_date_upload`, `test_date_deadline`) VALUES
(112, 'CMSC57 Test 1', 41, 5, 'FINISHED', '2013-03-05 12:50:11', '2013-03-07 16:00:00'),
(113, 'SAMPLE TEST', 41, 1, 'FINISHED', '2013-03-05 13:22:33', '2013-03-06 12:00:00'),
(118, 'knn', 38, 1, 'UNFINISHED', '2013-03-04 16:00:00', '2013-03-07 12:08:00'),
(119, 'Sample Test', 41, 1, 'UNFINISHED', '2013-03-04 16:00:00', '2013-03-08 10:00:00');

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
(112, 13),
(113, 13),
(119, 13);

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
(109, 47),
(109, 48),
(109, 49),
(109, 50),
(109, 51),
(110, 52),
(110, 53),
(110, 54),
(110, 55),
(110, 56),
(111, 57),
(112, 58),
(112, 59),
(112, 60),
(112, 61),
(112, 62),
(113, 63),
(113, 63),
(113, 64),
(114, 64),
(115, 65),
(116, 66),
(117, 67),
(118, 68),
(119, 69);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_uname`, `user_password`, `user_fname`, `user_type`) VALUES
(37, 'jeanmanas', 'cf1a129dd176d3e38a2ed6eb509b6e11', 'Jean Manas', 'Student'),
(38, 'judemailom', '22640e56726a08dda37214dcb00cf647', 'Jude Mailom', 'Teacher'),
(39, 'seforagalos', 'a3960385abb4fbb7f19bb452bd9e7921', 'Sefora Galos', 'Student'),
(40, 'marjmarinay', '1fb49c1ee9907a7ac1ac0b23775c0a76', 'Marj Marinay', 'Student'),
(41, 'julianaseneta', 'b97a4c79f9eaacff59bd739c839a2a2c', 'Julian Aseneta', 'Teacher'),
(42, 'student1', 'b1b0ae6d6b439ba1495805a87c54c714', 'Student One', 'Student'),
(43, 'student2', '213ee683360d88249109c2f92789dbc3', 'Student Two', 'Student'),
(44, 'student3', '8e4947690532bc44a8e41e9fb365b76a', 'Student Three', 'Student');

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
