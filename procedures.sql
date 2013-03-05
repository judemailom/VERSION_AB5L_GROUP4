DROP PROCEDURE IF EXISTS add_test;
DELIMITER $$
CREATE PROCEDURE add_test(_id INT(64), _title VARCHAR(64), _author_id INT(64), _test_length INT(64), _test_status ENUM('FINISHED', 'UNFINISHED'), _test_date_uploaded TIMESTAMP, _test_date_finished TIMESTAMP)
BEGIN
	INSERT INTO test VALUES(_id, _title, _author_id, _test_length, _test_status, _test_date_uploaded, _test_date_finished);
	SELECT last_insert_id();
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS add_test_classlist;
DELIMITER $$
CREATE PROCEDURE add_test_classlist(_test_id INT(64), _classlist_name VARCHAR(64))
BEGIN
	INSERT INTO test_classlist VALUES(_test_id, (SELECT classlist_id FROM classlist WHERE classlist_name = _classlist_name));
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS add_question;
DELIMITER $$
CREATE PROCEDURE add_question(_question_id INT(64), _test_id INT(64), _question VARCHAR(64), _choice_a VARCHAR(64), _choice_b VARCHAR(64), _choice_c VARCHAR(64), _choice_d VARCHAR(64), _correct_answer ENUM('A', 'B', 'C', 'D'), _item_number INT(64))
BEGIN
	INSERT INTO question VALUES(_question_id, _test_id, _question, _choice_a, _choice_b, _choice_c, _choice_d, _correct_answer, _item_number);
	SELECT last_insert_id();
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS get_unfinished_tests;
DELIMITER $$
CREATE PROCEDURE get_unfinished_tests(_user_id INT(64))
BEGIN
	SELECT * FROM test WHERE test_status = "UNFINISHED" AND test_id IN (SELECT test_id FROM test_classlist WHERE classlist_id IN (SELECT classlist_id FROM classlist_members WHERE classlist_user_id = _user_id));
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS get_finished_tests;
DELIMITER $$
CREATE PROCEDURE get_finished_tests(_user_id INT(64))
BEGIN
	SELECT * FROM test WHERE test_status = "FINISHED" AND test_id IN (SELECT test_id FROM test_classlist WHERE classlist_id IN (SELECT classlist_id FROM classlist_members WHERE classlist_user_id = _user_id));
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS delete_test;
DELIMITER $$
CREATE PROCEDURE delete_test(_test_id INT(64))
BEGIN
	DELETE FROM question WHERE test_id=_test_id;
	DELETE FROM test WHERE test_id=_test_id;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS delete_forum;
DELIMITER $$
CREATE PROCEDURE delete_forum(_forum_id INT(64))
BEGIN
	DELETE FROM forum WHERE forum_id=_forum_id;
	DELETE FROM forum_members WHERE forum_id=_forum_id;
	DELETE FROM forum_posts WHERE forum_id=_forum_id;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS add_comment;
DELIMITER $$
CREATE PROCEDURE add_comment(_post_id INT(64), _forum_id INT(64), _user_id INT(64), _date TIMESTAMP, _content TEXT)
BEGIN
	INSERT INTO forum_posts VALUES(_post_id, _forum_id, _user_id, _date, _content);
	SELECT last_insert_id();
END $$
DELIMITER ;