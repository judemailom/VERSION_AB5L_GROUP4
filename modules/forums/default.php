<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	if(isset($_SESSION['taking_exam'])){
		$auth = performQuery('SELECT test_author_id FROM test WHERE test_id = '.$_SESSION['test_id'].';');
		$a = performQuery('INSERT INTO examresults VALUES('.$_SESSION['user_id'].', 0, '.$_SESSION['test_id'].', '.$auth[0]['test_author_id'].');');
		include 'js/taking_exam.js';
		unset($_SESSION['taking_exam']);
	}
	//unset($_SESSION['forum_id']);
/*	
	if(isset($_POST['create_forum'])){
			$a = performQuery('INSERT INTO forum VALUES ("", "'.$_POST['forum_name'].'", "'.$_POST['forum_desc'].'", '.$USER[0]['user_id'].');');
			if($a){
				$_SESSION['success']=2;
				$_SESSION['mode'] = 'created';
			}
			else
				$_SESSION['success']=0;
			header('location: #');
	}
	if(isset($_POST['edit_forum'])){
		$_SESSION['forum_id'] = $_POST['forum_id'];
		header('location: ?page=edit_forum_members');
	}
	
	if(isset($_POST['delete_forum'])){
		$a = performQuery('CALL delete_forum('.$_POST['forum_id'].')');
		if($a){
				$_SESSION['success']=2;
				$_SESSION['mode'] = 'deleted';
			}
			else
				$_SESSION['success']=0;
			header('location: #');
	}
*/?>	

<div class="row-fluid">
	<div class="span8 forum-content">
	</div>
	
</div>
