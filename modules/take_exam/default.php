<?php 
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	 
	$test_id = $_SESSION['test_id'];
	$test =  performQuery("SELECT * FROM TEST WHERE TEST_ID = $test_id");
	$classlists = performQuery('SELECT classlist_name FROM classlist WHERE classlist_id IN (SELECT classlist_id FROM test_classlist WHERE test_id = '.$test[0]['test_id'].');');
	$author = performQuery('SELECT user_uname FROM user WHERE user_id = '.$test[0]['test_author_id'].';');

?>
<?php
if(isset($_POST['takeExam'])){
	unset($_SESSION['taking_exam']);

	var_dump($_SESSION);
	var_dump($_POST);
	$test_id = $_SESSION['test_id'];
	//var_dump($test_id);
	//$test_key = $_SESSION['test_key'];
	$test =  performQuery("SELECT * FROM TEST WHERE TEST_ID = $test_id");
	$classlists = performQuery("SELECT classlist_name FROM classlist WHERE classlist_id IN (SELECT classlist_id FROM test_classlist WHERE test_id = {$test[0]['test_id']})");
	var_dump($classlists);
	//$author = performQuery('SELECT user_uname FROM user WHERE user_id = '.$test[0]['test_author_id'].';');
	$student_id = $_SESSION['user_id'];	
	//$j= 0;
	$k= 1;
	$correct = 0;
	
			
	$result = performQuery("select test_item_number, test_correct_answer from question where test_id=\"{$test_id}\"; ");		// $result = questions of exam '$testTitle'
	//var_dump($_POST['Q'.$i]);
	for($i=0; $i<sizeof($result); $i++) {
	//	var_dump($_POST['Q'][$i]);
		$authora = $test[0]['test_author_id'];
		if($k== $result[0]['test_item_number'] && $_POST['Q'.$i] == $result[0]['test_correct_answer']){
			$correct+=1;	
			//$j++;
			$k++;
		}
	}
	//check if existing na sa db

	$c = performQuery("insert into examresults(student_id, score, test_id, author_id) values({$student_id},  {$correct}, {$test_id},  {$authora} );");
	include "js/exam_taken_score.js";
}

if(isset($_SESSION['success']) && $_SESSION['success']>=1){ ?>
	<div class="alert alert-success">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Congratulations!</strong> Successfully <?php echo $_SESSION['mode']; ?> a test.
	</div>
<?php
}
else if(isset($_SESSION['success']) && $_SESSION['success']<0){ ?>
	<div class="alert alert-error">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Sorry!</strong> Something went wrong. Please try again. 
	</div>
<?php }
if(isset($_SESSION['success'])){
	if(($_SESSION['success']==1 || $_SESSION['success']<0)){
		unset($_SESSION['success']);
		unset($_SESSION['mode']);
	}
	else
		$_SESSION['success']-=1;
}
?>
<div id="take_exam">
	<div class="container-fluid">
		<div class="row-fluid">
			<h3><?php echo $test[0]['test_name']; ?></h3>
		</div>
		<div class="row-fluid">
			Published on <?php echo $test[0]['test_date_upload']; ?> with a deadline of <?php echo $test[0]['test_date_deadline']; ?><br />
			For classlists 
			<?php
			for($j=0;$j<sizeof($classlists);$j++){
				if(!isset($classlists->num_rows))
					echo " ".$classlists[$j]['classlist_name'];
				}
			?>
		</div>
		<div class="row-fluid">
			<?php echo $test[0]['test_length']; ?> items
		</div>
		<div class="row-fluid">
			Posted by <?php echo $author[0]['user_uname']; ?>
		</div>
		<?php
			$result = performQuery("select * from question where test_id={$test_id} order by test_item_number; ");		// $result = questions of exam '$testTitle'
		?>	

			<form method='post' action='#'>
		<?php
			for($i=0; $i<sizeof($result); $i++) {	
				echo $result[$i]['test_item_number'].". ".$result[$i]['question'];	
		?>
				</br>	
				<input type='radio' name="Q<?php echo $i; ?>" value="A"> A. <?php echo $result[$i]['test_choice_a']; ?><br/>
				<input type='radio' name="Q<?php echo $i; ?>" value="B"> B. <?php echo $result[$i]['test_choice_b']; ?><br/>
				<input type='radio' name="Q<?php echo $i; ?>" value="C"> C. <?php echo $result[$i]['test_choice_c']; ?><br/>
				<input type='radio' name="Q<?php echo $i; ?>" value="D"> D. <?php echo $result[$i]['test_choice_d']; ?><br/>
			
			<?php	} ?>
			
			<input type='submit' value="Pass Exam" name = 'takeExam'/>
			</form>
	</div>
</div>

<div id="exam_taken_score" class=" modal hide fade" data-toggle= "modal" tabindex="-1" role="dialog" aria-labelledby="exam_taken_score" aria-hidden="true">	
	<div class="modal-header">
		
		<h3>your score is : <?php echo $correct; ?> !</h3>
		  
	</div>
	<div class="modal-header">
		<a href="#" class="btn btn-primary" data-dismiss = "modal" onclick="okClicked();">OK</a>
	</div>		
</div>

