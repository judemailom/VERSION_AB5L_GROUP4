<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<div id="add_test">
	<?php
		if(!isset($_POST['next_step']) && !isset($_POST['add_question']) && !isset($_POST['submit_test'])){
	?>
	<div class="container-fluid">
		<div class="row-fluid">
			<h3>Create a test</h3>
		</div>
		<div class="row-fluid">
			<form action="" method="post">
				<div class="span6">
					<label>Please fill in the following fields</label>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-edit"></i></span>
						<input required="required" class="input input-xxlarge" name="test_title" id="prependedInput" type="text" placeholder="Title of the test...">
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-list"></i></span>
						<input required="required" class="input input-xxlarge" name="test_description" id="prependedInput" type="text" placeholder="Some descriptions/details...">
					</div>
					<label>
						Deadline of the test: MM/DD/YYYY
					</label>
					<div class="row-fluid">
							<input type="date" name="test_date_deadline" class="span3" />
					</div>
					<label>
					Please check the classlists that are required for this test
					</label>
					<div class="row-fluid">
						<div id="cl">
							<?php 
							$list = performQuery('select classlist_name from classlist where classlist_author_id = (select user_id from user where user_uname = "'.$_SESSION['user'].'");');
							//var_dump($list);
							if(!isset($list->num_rows)){
								for($i=0;$i<sizeof($list);$i++){ ?>
									<label class="checkbox"><input type="checkbox" value="<?php echo $list[$i]['classlist_name']; ?>" id="c_l<?php echo $i;?>" name="test_classlist<?php echo $i; ?>" /><?php echo $list[$i]['classlist_name']; ?></label>
								<?php }
							}
							else
								echo "You do not own any classlist.";
							?>
						</div>
					</div>
					<input type="submit" value="Start" name="next_step" />
				</div>
				<div class="span6">
					<div class="well">
						<h5>Some test reminders</h5>
						<ul>
							<li>Tests in iLearn are not editable</li>
							<li>Questions and answers will be provided in the upcoming steps</li>
							<li>Tests created are automatically labeled as UNFINISHED. Tests can only be categorized as FINISHED by the system on or after its due date.</li>
						</ul>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php }
		else if(isset($_POST['next_step']) || isset($_POST['add_question'])){ 
			if(isset($_POST['next_step']))
				$_SESSION['QUESTIONS'] = $_POST;
			else
				$_SESSION['QUESTIONS'] += $_POST;
			//var_dump($_SESSION);
			if(!isset($_SESSION['item']))	$_SESSION['item'] = 1;
			else $_SESSION['item']+=1;
		?>
		<form action="" method="post">
			<div class="container-fluid">
				<div class="span6">
					<label>
						Please fill in the following fields: 
					</label>
					<label>
						Question <?php echo $_SESSION['item'];?>
					</label>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-question-sign"></i></span>
						<input class="input-xxlarge" id="prependedInput" name="Q<?php echo $_SESSION['item'];?>" type="text" placeholder="Type question here...">
					</div>
					<label>
						Choices:
					</label>
					<div class="input-prepend">	
						<span class="add-on">A</span>
						<input class="input-xxlarge" type="text" required="required" placeholder="Choice A..." name="Q<?php echo $_SESSION['item'];?>_choice_A" />
					</div>
					<div class="input-prepend">	
						<span class="add-on">B</span>
						<input class="input-xxlarge" type="text" required="required" placeholder="Choice B..." name="Q<?php echo $_SESSION['item'];?>_choice_B" />
					</div>
					<div class="input-prepend">	
						<span class="add-on">C</span>
						<input class="input-xxlarge" type="text" required="required" placeholder="ChoiceC..." name="Q<?php echo $_SESSION['item'];?>_choice_C" />
					</div>
					<div class="input-prepend">	
						<span class="add-on">D</span>
						<input class="input-xxlarge" type="text" required="required" placeholder="Choice D..." name="Q<?php echo $_SESSION['item'];?>_choice_D" />
					</div>
					<div class="row-fluid">
						<select class="input-xxlarge" name="Q<?php echo $_SESSION['item'];?>_correct_answer">
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
						</select>
					</div>
					<div class="form-inline">
						<input type="submit" value="Add a question" name="add_question" />
						<input type="submit" value="Submit_test" name="submit_test" />
					</div>
				</div>
				<div class="span6">
					<div class="well">
						<h5>Some test reminders</h5>
						<ul>
							<li>Tests in iLearn are not editable</li>
							<li>Questions and answers will be provided in the upcoming steps</li>
							<li>Tests created are automatically labeled as UNFINISHED. Tests can only be categorized as FINISHED by the system on or after its due date.</li>
						</ul>
					</div>
				</div>
			</div>
		</form>
	<?php	}
		else if(isset($_POST['submit_test'])){
			$_SESSION['QUESTIONS'] += $_POST;
			//var_dump($_SESSION);
			$author_id = performQuery('select user_id from user where user_uname = "'.$_SESSION['user'].'";');
			$test_id = performQuery('CALL add_test("", "'.$_SESSION['QUESTIONS']['test_title'].'", '.$author_id[0]['user_id'].', '.$_SESSION['item'].', "UNFINISHED", "'.date('Y-m-d').'", "'.$_SESSION['QUESTIONS']['test_date_deadline'].'");');
			$i=0;
			 while(isset($_SESSION['QUESTIONS']['test_classlist'.$i])){
				$a = performQuery( 'CALL add_test_classlist('.$test_id[0]['last_insert_id()'].', "'.$_SESSION['QUESTIONS']['test_classlist'.$i].'");');
				//var_dump($a);
				$i++;
			}
			$i=1;
			while(isset($_SESSION['QUESTIONS']['Q'.$i])){
				$question_id = performQuery('CALL add_question("", '.$test_id[0]['last_insert_id()'].', "'.$_SESSION['QUESTIONS']['Q'.$i].'","'.$_SESSION['QUESTIONS']['Q'.$i.'_choice_A'].'", "'.$_SESSION['QUESTIONS']['Q'.$i.'_choice_B'].'", "'.$_SESSION['QUESTIONS']['Q'.$i.'_choice_C'].'", "'.$_SESSION['QUESTIONS']['Q'.$i.'_choice_D'].'", "'.$_SESSION['QUESTIONS']['Q'.$i.'_correct_answer'].'", '.$i.');');
				//var_dump($test_id);
				performQuery('INSERT INTO test_question VALUES('.$test_id[0]['last_insert_id()'].', '.$question_id[0]['last_insert_id()'].');');
			$i++;
			}
			$_SESSION['test_id'] = $test_id[0]['last_insert_id()'];
			//clear all uneccessary session values
			unset($_SESSION['item']);
			unset($_SESSION['QUESTIONS']);
			include_once 'js/add_test.js';
		}
	?>
</div>
<div id="add_test_success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="add_test_success" aria-hidden="true">
	<div class="modal-header">
		<h3>You have successfully published a test!</h3>
	</div>
	<div class="modal-footer">
		Some content here. Lorem ipsum chu chu.
	</div>
	<div class="modal-footer">
		<a href="?page=view_test&&test_id=<?php echo $_SESSION['test_id']; ?>" class="btn btn-primary" onclick="okClicked();">View test</a>
		<a href="?page=add_test" class="btn btn-primary" onclick="okClicked();">Create another test</a>
	</div>
</div>