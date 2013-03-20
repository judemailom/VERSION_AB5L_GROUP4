<?php
		session_start ();
		include "includes/query.php";
		$test_id = $_SESSION['test_id'];
		//var_dump($test_id);
		//$test_key = $_SESSION['test_key'];
		$test =  performQuery("SELECT * FROM TEST WHERE TEST_ID = $test_id");
		$classlists = performQuery("SELECT classlist_name FROM classlist WHERE classlist_id IN (SELECT classlist_id FROM test_classlist WHERE test_id = {$test[0]['test_id']})");
		var_dump($classlists);
		//$author = performQuery('SELECT user_uname FROM user WHERE user_id = '.$test[0]['test_author_id'].';');
		$student_id = $_SESSION['user_id'];	
?>


<?php
	$j= 1;
	$correct = 0;
	
			
	$result = performQuery("select test_item_number, test_correct_answerfrom question where test_id=\"{$test_id}\"; ");		// $result = questions of exam '$testTitle'
	
	for($i=0; $i<sizeof($result); $i++) {
		//echo "item no.{$item[0]} -> {$item[1]}<br/>";
		//echo $_POST[''. $i .''];
		$author = $test[0]['test_author_id'];
		if($i == $result[0]['test_item_number'] && $_POST[''. $j .''] == $result[0]['test_correct_answer']){
			$correct+=1;
		
		}
	}
	
	
	mysql_query("insert into examresults( student_id, test_id, score, author_id ) values(\"{$student_id}\",  \"{$test_id}\",  {$correct},  \"{$author}\" )");
	
	//echo $correct;
	//mysql_close ($conn);
	header ('Location:index.php?page=take_exam');
?>