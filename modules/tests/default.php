<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	if(isset($_POST['delete_test'])){
		var_dump($_POST);
		$a = performQuery('CALL delete_test('.$_POST['test_id'].');');
		if($a){
			$_SESSION['success']=2;
			$_SESSION['mode'] = 'deleted';
		}
		else
			$_SESSION['success']=0;
		header('location: #');

	}
	if(isset($_GET['func']) && $_GET['func']=='add_test')
		header('location: ?page=add_test');
	$user = performQuery('SELECT * FROM user WHERE user_uname = "'.$_SESSION['user'].'"'); 
	//--------  Due tests
	$due = performQuery('SELECT test_id FROM test WHERE test_date_deadline <= "'.date('Y-m-d').'";');
	if(!isset($due->num_rows)){
		for($i=0;$i<sizeof($due);$i++)
			performQuery('UPDATE test SET test_status="FINISHED" WHERE test_id = '.$due[$i]['test_id'].';');
	}
	//--------
	?>
	
<?php 
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
<div id="test">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span9">
				<div class="row-fluid">
					<!--FINISHED TESTS-->
					<div class="span12 well">
						<h4>Finished tests</h4>
						<table class="table table-striped">
							<tr>
								<th>Test name</th>
								<th>Classlis(s)</th>
								<th>Length</th>
								<th>Date uploaded</th>
								<th>Deadline</th>
								<th colspan="3">Actions</th>
							</tr>
							<?php
								if($user[0]['user_type']=='Teacher'){
								$finished = performQuery('select * from test where test_status = "FINISHED" and test_author_id = (select user_id from user where user_uname = "'.$_SESSION['user'].'");');
								}
								else{
								$finished = performQuery('CALL get_finished_tests('.$user[0]['user_id'].');');
								}
								if(!isset($finished->num_rows)){
									for($i=0;$i<sizeof($finished);$i++){ 
									?>
								<tr>
									<td><?php echo $finished[$i]['test_name']; ?></td>
									<td><?php
										//fetch classlist associated to the test
										$classlist = performQuery('select classlist_name from classlist where classlist_id in (select classlist_id from test_classlist where test_id = '.$finished[$i]['test_id'].');');
										for($j=0;$j<sizeof($classlist);$j++)
											if(!isset($classlist->num_rows))
												echo " ".$classlist[$j]['classlist_name'];
										
										//echo classlists
									?></td>
									<td><?php echo $finished[$i]['test_length']; ?></td>
									<td><?php echo $finished[$i]['test_date_upload']; ?></td>
									<td><?php echo $finished[$i]['test_date_deadline']; ?></td>
									<td>
											<input type="submit" value="" name="view_top_scorers" class="action"/>
									</td>						
									<?php
									if($user[0]['user_type']=='Teacher'){
									?>
									<td>
										<form action="" method="post" onsubmit="return confirm_delete();">
											<input type="submit" value="Delete test" name="delete_test" class="action"/>
											<input type="hidden" value="<?php echo $finished[$i]['test_id']; ?>" name="test_id" class="action"/>
										</form>
									</td>
									<td>
										<form action="?page=view_test&&test_id=<?php echo $finished[$i]['test_id']; ?>" method="post">
											<input type="submit" value="View test" name="view_test" class="action"/>
										</form>
									</td>	
								<?php	}
									}
								}
								else{ ?>
									<tr><td colspan="6">No existing test in this category.</td></tr>
								<?php } ?>
							</tr>
						</table>
						</div>

					<!--UNFINISHED TESTS-->
					<div class="row-fluid">
						<div class="span12 well">
							<h4>Unfinished tests</h4>
							<div class="row-fluid">
								<div class="span12">
									<table class="table table-striped">
										<tr>
											<th>Test name</th>
											<th>Classlis(s)</th>
											<th>Length</th>
											<th>Date uploaded</th>
											<th>Deadline</th>
											<th colspan="3">Actions</th>
										</tr>

										<?php if($user[0]['user_type']=='Teacher'){ ?>
											<tr id = "create">
												<td colspan="8" id="create"><a name="create" id="create" href="?page=tests&&func=add_test">&plus; Create new unfinished test...</a></td>
											</tr>
										<?php }
										if($user[0]['user_type']=='Teacher'){
											$unfinished = performQuery('select * from test where test_status = "UNFINISHED" and test_author_id = (select user_id from user where user_uname = "'.$_SESSION['user'].'");');
										}
										else{
											$unfinished = performQuery('CALL get_unfinished_tests('.$user[0]['user_id'].');');
										}
										//	var_dump($unfinished);
											if(!isset($unfinished->num_rows)){
												for($i=0;$i<sizeOf($unfinished);$i++){
												?>
											<tr>
												<td><?php echo $unfinished[$i]['test_name']; ?></td>
												<td><?php
													//fetch classlist associated to the test
													$classlist = performQuery('select classlist_name from classlist where classlist_id in (select classlist_id from test_classlist where test_id = '.$unfinished[$i]['test_id'].');');
											for($j=0;$j<sizeof($classlist);$j++){
												if(!isset($classlist->num_rows))
													echo " ".$classlist[$j]['classlist_name'];
											}
												?></td>
												<td><?php echo $unfinished[$i]['test_length']; ?></td>
												<td><?php echo $unfinished[$i]['test_date_upload']; ?></td>
												<td><?php echo $unfinished[$i]['test_date_deadline']; ?></td>
												<td class="dropdown">
												<?php
													if($user[0]['user_type']=='Student'){
												?>
													<form action="" method="post">
														<div class="btn-group">
														  <input type="submit" class="action" value="Take exam" data-toggle="dropdown">
														    Take exam
														  </a>
														  <ul class="dropdown-menu take_exam">
														    <div class="input-prepend">
															  <span class="add-on"><i class="icon-pencil"></i></span>
															  <input class="input-medium" name="exam_id" id="prependedInput" type="text" placeholder="Exam ID">
															</div>
															<div class="input-prepend">
															  <span class="add-on"><i class="icon-user"></i></span>
															  <input class="input-medium" name="student_id" id="prependedInput" type="text" placeholder="Student ID">
															</div>
															<a name="take_exam" class="btn btn-large btn-block" href="#">Go!</a>
														  </ul>
														</div>
													</form>
												</td>						
												<?php } 
												if($user[0]['user_type']=='Teacher'){
												?>
												<td>
													<form action="" method="post" onsubmit="return confirm_delete();">
														<input type="submit" value="" name="delete_test" class="action"/>
														<input type="hidden" value="<?php echo $unfinished[$i]['test_id']; ?>" name="test_id" class="action"/>
													</form>
												</td>
												<td>
													<form action="?page=view_test&&test_id=<?php echo $unfinished[$i]['test_id']; ?>" method="post">
														<input type="submit" value="" name="view_test" class="action"/>
													</form>
												</td>
												<?php } ?>
											</tr>
											<?php
												}
											}else{ ?>
											<tr><td colspan="6">No existing test in this category.</td></tr>
									<?php } ?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function confirm_delete(){
	return confirm('Are you sure you want to delete this test?');
};
</script>