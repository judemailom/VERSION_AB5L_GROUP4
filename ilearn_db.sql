-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2013 at 02:05 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ilearn_db`
--
USE ilearn_db;

DELIMITER $$
--
-- Procedures
--

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_comment`(_post_id INT(64), _forum_id INT(64), _user_id INT(64), _date TIMESTAMP, _content TEXT)
BEGIN
	INSERT INTO forum_posts VALUES(_post_id, _forum_id, _user_id, _date, _content);
	SELECT last_insert_id();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_question`(_question_id INT(64), _test_id INT(64), _question VARCHAR(64), _choice_a VARCHAR(64), _choice_b VARCHAR(64), _choice_c VARCHAR(64), _choice_d VARCHAR(64), _correct_answer ENUM('A', 'B', 'C', 'D'), _item_number INT(64))
BEGIN
	INSERT INTO question VALUES(_question_id, _test_id, _question, _choice_a, _choice_b, _choice_c, _choice_d, _correct_answer, _item_number);
	SELECT last_insert_id();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_test`(_key VARCHAR(64), _id INT(64), _title VARCHAR(64), _author_id INT(64), _test_length INT(64), _test_status ENUM('FINISHED', 'UNFINISHED'), _test_date_uploaded TIMESTAMP, _test_date_finished TIMESTAMP)
BEGIN
	INSERT INTO test VALUES(_key, _id, _title, _author_id, _test_length, _test_status, _test_date_uploaded, _test_date_finished);
	SELECT last_insert_id();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_test_classlist`(_test_id INT(64), _classlist_name VARCHAR(64))
BEGIN
	INSERT INTO test_classlist VALUES(_test_id, (SELECT classlist_id FROM classlist WHERE classlist_name = _classlist_name));
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_forum`(_forum_id INT(64))
BEGIN
	DELETE FROM forum WHERE forum_id=_forum_id;
	DELETE FROM forum_members WHERE forum_id=_forum_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_test`(_test_id INT(64))
BEGIN
	DELETE FROM question WHERE test_id=_test_id;
	DELETE FROM test WHERE test_id=_test_id;
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

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_comp`) VALUES
(49, 'COMPANY'),
(50, 'COMPANY'),
(51, 'l;k;l');

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
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `author_id`, `announcement_title`, `announcement_content`) VALUES
(1, 38, 'ANNOUNCEMENT!', 'CONTENT!'),
(2, 41, 'ISA PA!', 'The history of computer programming\r\nis a steady move away from machineoriented\r\nviews of programming towards\r\nconcepts and metaphors that more\r\nclosely reflect the way in which we\r\nourselves understand the world'),
(3, 38, 'OK na ba?', 'OK NA!!!					'),
(4, 45, 'Announcement for School2', 'Announcement for School 2');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `classlist`
--

INSERT INTO `classlist` (`classlist_id`, `classlist_name`, `classlist_author_id`) VALUES
(12, 'CMSC22 Section Jude - Classlist', 38),
(13, 'CMSC57 Section Julian - Classlist', 41),
(14, 'MATH17', 53),
(15, 'CMSC 11', 53);

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
(12, 37),
(12, 39),
(12, 40),
(13, 37),
(13, 39),
(13, 40);

-- --------------------------------------------------------

--
-- Table structure for table `examresults`
--

CREATE TABLE IF NOT EXISTS `examresults` (
  `student_id` varchar(4) NOT NULL,
  `score` int(3) NOT NULL,
  `test_id` varchar(4) NOT NULL,
  `author_id` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examresults`
--

INSERT INTO `examresults` (`student_id`, `score`, `test_id`, `author_id`) VALUES
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '129', 38),
('37', 0, '128', 38),
('39', 0, '128', 38),
('39', 1, '129', 38),
('39', 1, '123', 41),
('39', 1, '124', 41),
('39', 1, '122', 41),
('37', 0, '122', 41);

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
  `forum_id` int(64) NOT NULL AUTO_INCREMENT,
  `forum_name` varchar(64) NOT NULL,
  `forum_description` varchar(64) NOT NULL,
  `forum_author_id` int(64) NOT NULL,
  `forum_key` varchar(64) NOT NULL,
  PRIMARY KEY (`forum_id`),
  KEY `forum_author_id` (`forum_author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=163 ;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `forum_name`, `forum_description`, `forum_author_id`, `forum_key`) VALUES
(19, 'Forum ni Jude', 'CMSC22 Students', 38, 'forum'),
(25, 'iLEARN Incomplete Functionalities', 'iLEARN Incomplete Functionalities', 38, 'ab4lg5'),
(99, 'PORUM', 'PORUM', 50, 'porum'),
(102, 'another one', 'dfsdf', 50, ''),
(114, 'forum pa', 'technical', 50, ''),
(116, 'NOOB', 'NOOB', 50, ''),
(133, 'New forum by admin one', 'admin one', 50, 'admin one'),
(135, 'Title of forum', 'Description of that forum', 41, 'forumkey'),
(152, 'jkJj', 'j', 41, 'jj'),
(153, 'kk', 'j', 41, 'j'),
(154, 'lk;lkl', 'k;lkl;', 41, 'jkljlkj'),
(155, 'jghkj', 'gkgk', 41, 'hkhk'),
(156, 'kjljl', 'jlkjl', 41, 'kjkljl'),
(157, 'kjlj', 'kjj', 41, 'ljjl'),
(158, 'ghfghf', 'hfg', 41, 'fghf'),
(159, 'iyuttyu', 'tyututyutyu', 41, 't'),
(160, 'gsdfgs', 'gfsgf', 41, 'sgfj'),
(161, 'jhghjfghj', 'fhjgjhghj', 41, 'jhjgkj'),
(162, 'tagqq', 'th-list', 53, 'raven');

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
(19, 37),
(19, 39),
(19, 40),
(25, 37),
(25, 40),
(25, 41),
(135, 37),
(135, 39);

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
  KEY `forum_id` (`forum_id`,`forum_post_author_id`),
  KEY `forum_post_author_id` (`forum_post_author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

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
(69, 21, 37, '2013-03-05', 'ISA PAAA!'),
(72, 21, 41, '2013-03-05', 'ANOTHER ONE'),
(73, 24, 37, '2013-03-06', 'jsdfsdfsd'),
(76, 21, 37, '2013-03-06', 'one\r\n'),
(78, 22, 37, '2013-03-14', 'Another post'),
(81, 19, 37, '2013-03-15', 'sdasjdhkas\r\n'),
(83, 89, 50, '2013-03-15', 'POOOOOSST'),
(84, 89, 50, '2013-03-15', 'THER POSSSSSSSSSSSSSST'),
(90, 90, 50, '2013-03-17', 'adminadmin'),
(91, 90, 50, '2013-03-17', 'adminone'),
(93, 25, 41, '2013-03-17', 'test id '),
(94, 25, 41, '2013-03-17', 'student id upon registration, checking in exam taking'),
(95, 25, 41, '2013-03-17', 'i-javascript lahat ng fields, pano kung hindi supported ang html5'),
(98, 136, 39, '2013-03-17', 'jkhkjh'),
(101, 135, 39, '2013-03-17', 'some comment'),
(102, 135, 39, '2013-03-17', 'another comment thoudh'),
(103, 135, 39, '2013-03-17', 'ihfkl'),
(104, 135, 39, '2013-03-17', 'lkj'),
(105, 135, 39, '2013-03-17', 'sdfhkjl'),
(107, 135, 39, '2013-03-17', 'khlj'),
(108, 135, 39, '2013-03-17', 'jkhlkh'),
(109, 19, 38, '2013-03-17', 'kjljk'),
(113, 162, 53, '2013-03-18', 'asdfad'),
(115, 162, 53, '2013-03-18', '--');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

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
(69, 119, 'Question 1', 'Choice A', 'Choice B', 'Choice C', 'Choice D', 'C', 1),
(71, 122, 'QUESTION1', 'a', 'b', 'c', 'd', 'D', 1),
(72, 123, 'question 1', 'a', 'b', 'c', 'd', 'C', 1),
(73, 124, 'jhkjhkj', 'hkjhkjsdhjk', 'hkj', 'hkjhkj', 'csdcs', 'B', 1),
(74, 125, 'nkj', 'hkjh', 'kh', 'jjh', 'kjhj', 'A', 1),
(77, 127, 'jhhhkjhk', 'hjhk', 'hkj', 'hk', 'hkj', 'A', 1),
(78, 128, 'jhkh', 'khkj', 'hk', 'hk', 'hjk', 'A', 1),
(79, 129, 'question 1', 'a', 'b', 'c', 'd', 'A', 1),
(80, 129, 'question 2', 'a', 'b', 'c', 'd', 'B', 2);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `test_id` varchar(4) NOT NULL,
  `question` varchar(255) NOT NULL,
  `choice_a` varchar(255) NOT NULL,
  `choice_b` varchar(255) NOT NULL,
  `choice_c` varchar(255) NOT NULL,
  `choice_d` varchar(255) NOT NULL,
  `correct_answer` varchar(1) NOT NULL,
  `item_no` int(255) NOT NULL,
  `author_id` int(9) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`test_id`, `question`, `choice_a`, `choice_b`, `choice_c`, `choice_d`, `correct_answer`, `item_no`, `author_id`, `date`) VALUES
('0123', 'bakit?', 'da', 'dab', 'dab', 'ab', 'd', 1, 212345678, '2013-02-28'),
('0123', 'bakit?', 'db', 'dsb', 'dahil', 'ano e', 'a', 2, 212345678, '2013-02-28'),
('0111', 'bakit?', 'kasi', 'si ano e', 'kasi e', 'dahil sa ano', 'c', 1, 212345678, '2013-02-15'),
('0101', 'anong masarap na ulam?', 'ginisa', 'nilaga', 'kaldereta', 'wala', 'c', 1, 123456789, '2013-02-05');

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
(42, 'SCHOOL1', 3),
(43, 'SCHOOL2', 1),
(44, 'SCHOOL2', 2),
(46, 'SCHOOL2', 2),
(52, 'SCHOOL1', 0);

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
(41, 'ICS', 'SCHOOL1'),
(45, 'ICS', 'SCHOOL2'),
(47, 'ERD', 'SCHOOL2'),
(37, 'dfs', 'SCHOOL1'),
(48, 'sdfsd', 'SCHOOL2'),
(53, 'SSP', 'SCHOOL4');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `test_key` varchar(64) NOT NULL,
  `test_id` int(64) NOT NULL AUTO_INCREMENT,
  `test_name` varchar(64) NOT NULL,
  `test_author_id` int(64) NOT NULL,
  `test_length` int(64) NOT NULL,
  `test_status` enum('FINISHED','UNFINISHED') NOT NULL,
  `test_date_upload` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `test_date_deadline` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`test_id`),
  KEY `test_author_id` (`test_author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_key`, `test_id`, `test_name`, `test_author_id`, `test_length`, `test_status`, `test_date_upload`, `test_date_deadline`) VALUES
('testkey', 112, 'CMSC57 Test 1', 41, 5, 'FINISHED', '2013-03-18 12:17:59', '2013-03-07 16:00:00'),
('testkey', 113, 'SAMPLE TEST', 41, 1, 'FINISHED', '2013-03-18 12:18:05', '2013-03-06 12:00:00'),
('testkey', 118, 'knn', 38, 1, 'FINISHED', '2013-03-18 12:18:10', '2013-03-07 12:08:00'),
('testkey', 119, 'Sample Test', 41, 1, 'FINISHED', '2013-03-18 12:18:16', '2013-03-08 10:00:00'),
('title_key', 120, 'TITLE TEST', 41, 2, 'UNFINISHED', '2013-03-17 16:00:00', '2013-03-21 00:00:00'),
('key', 122, 'title', 41, 1, 'FINISHED', '2013-03-18 12:53:41', '2012-01-01 10:00:00'),
('testkey', 123, 'title ng test', 41, 1, 'UNFINISHED', '2013-03-17 16:00:00', '2013-03-22 13:09:00'),
('sdas', 124, 'isa pang test', 41, 1, 'UNFINISHED', '2013-03-17 16:00:00', '2013-03-21 13:09:00'),
('hkjh', 125, 'jhkjhkj', 41, 1, 'FINISHED', '2013-03-18 13:05:07', '2012-08-07 12:18:00'),
('kjh', 127, 'jhkh', 38, 1, 'FINISHED', '2013-03-19 17:44:12', '0000-00-00 00:00:00'),
('kjhkjh', 128, 'hkjhkj', 38, 1, 'UNFINISHED', '2013-03-18 16:00:00', '2013-03-29 07:00:00'),
('test', 129, 'test', 38, 2, 'UNFINISHED', '2013-03-18 16:00:00', '2013-03-28 13:00:00');

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
(119, 13),
(122, 13),
(123, 13),
(124, 13),
(125, 13),
(127, 12),
(128, 12),
(129, 12);

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
(119, 69),
(121, 70),
(122, 71),
(123, 72),
(124, 73),
(125, 74),
(126, 75),
(126, 76),
(127, 77),
(128, 78),
(129, 79),
(129, 80);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

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
(45, 'teacher1', '41c8949aa55b8cb5dbec662f34b62df3', 'Teacher One', 'Teacher'),
(46, 'dummyaccount', '050706f43c69942c7c2b80153ecaef59', 'Dummy Account', 'Student'),
(50, 'adminone', 'f6fdffe48c908deb0f4c3bd36c032e72', 'First Admin', 'Administrator'),
(51, 'adminadmin', 'f6fdffe48c908deb0f4c3bd36c032e72', 'Administrator', 'Administrator'),
(53, 'ravenjohn', '04351f72e3e9177f69ff84f4ef736450', 'Raven Lagrimas', 'Teacher');

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
  ADD CONSTRAINT `forum_ibfk_2` FOREIGN KEY (`forum_author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forum_members`
--
ALTER TABLE `forum_members`
  ADD CONSTRAINT `forum_members_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `forum_members_ibfk_2` FOREIGN KEY (`forum_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD CONSTRAINT `forum_posts_ibfk_1` FOREIGN KEY (`forum_post_author_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
