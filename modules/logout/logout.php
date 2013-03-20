<?php 
	if(isset($_SESSION['taking_exam'])){
		$auth = performQuery('SELECT test_author_id FROM test WHERE test_id = '.$_SESSION['test_id'].';');
		$a = performQuery('INSERT INTO examresults VALUES('.$_SESSION['user_id'].', 0, '.$_SESSION['test_id'].', '.$auth[0]['test_author_id'].');');
		include 'js/taking_exam.js';
		unset($_SESSION['taking_exam']);
	}
	session_destroy();
	header('location: index.php');
?>