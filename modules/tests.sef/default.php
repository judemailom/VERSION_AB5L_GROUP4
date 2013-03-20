<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	if(isset($_POST['delete_test'])){
		var_dump($_POST);
		$a = performQuery('CALL delete_test('.$_POST['test_id'].');');
		
		$_SESSION[$_POST['test_id']];
		
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
								<th colspan="4">Actions</th>
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
											<a href="#view_top_scorers_success" data-toggle="modal">eto </a>
									</td>						

									
									<?php
									//include 'js/view_top_scorers_success.js';
		
									if($user[0]['user_type']=='Teacher'){
									?>
									<td>
										<form action="" method="post" onsubmit="return confirm_delete();">
											<input type="submit" value="" name="delete_test" class="action delete"/>
											<input type="hidden" value="<?php echo $finished[$i]['test_id']; ?>" name="test_id" class="action"/>
										</form>
									</td>
									<td>
										<form action="?page=view_test&&test_id=<?php echo $finished[$i]['test_id']; ?>" method="post">
											<input type="submit" value="" name="view_test" class="action enter"/>
										</form>
									</td>
									<td>
										<form action="?page=view_exam_result&&test_id=<?php echo $finished[$i]['test_id']; ?>" method="post">
											<input type="submit" value="" name="view_all_scores" class="action scores"/>
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

												<!--------------------------------------TEST KEY MODAL---------------------------------------->
													<div id="test_key<?php echo $i; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="test_key" aria-hidden="true">	
														<form action = "check_test_key.php" method="POST" onsubmit="return validate_test_key(this);">	
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																<h4>Please enter test key</h4>
															</div>
															<div class="modal-body">
																<div class="test_key_class"></div>
																<div class="input-prepend">
																  <span class="add-on"><i class="icon-check"></i></span>
																  <input class="span10" name="test_key" id="prependedInput" type="text" placeholder="Test key..." required="required" />
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" value="Go!" name="take_exam" />
																<input type="hidden" value="<?php echo $unfinished[$i]['test_id']?>" name="test_id" />
															</div>
														</form>
													</div>
												<!--------------------------------------TEST KEY MODAL---------------------------------------->

													<form action="" method="POST">
														<a name="test_key" data-toggle="modal" title="Take exam" id="test_key" href="#test_key<?php echo $i; ?>"><i class="icon-edit"></i></a>
													</form>
												</td>						
												<?php } 
												if($user[0]['user_type']=='Teacher'){
												?>
												<td>
													<form action="" method="post" onsubmit="return confirm_delete();">
														<input type="submit" title="Delete test" value="" name="delete_test" class="action delete"/>
														<input type="hidden" value="<?php echo $unfinished[$i]['test_id']; ?>" name="test_id" class="action"/>
													</form>
												</td>
												<td>
													<form action="?page=view_test&&test_id=<?php echo $unfinished[$i]['test_id']; ?>" method="post">
														<input type="submit" title="View test" value="" name="view_test" class="action enter"/>
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
					<div id="view_top_scorers_success" class=" modal hide fade" data-toggle= "modal" tabindex="-1" role="dialog" aria-labelledby="view_top_scorers_success" aria-hidden="true">	
										<div class="modal-header">
											<h3>top scorers</h3>
											<?php  
												if($user[0]['user_type']=='Teacher'){
													$top = mysql_query('select * from examresults where author_id = (select user_id from user where user_uname = "'.$_SESSION['user'].'"); order by score' );
													echo "<h1>EXAM RESULTS</h1>";
													echo "<table>";
													echo "<tr>";
													echo "<td>Student ID</td> <td>Score</td>";
													echo "</tr>";
													for($i = 0; $i<10; $i++){
														while ($item1 = mysql_fetch_array ($result)) {
															echo "<tr>";
															echo "<td> {$item1[0]}</td> <td>{$item1[1]}</td>";
															echo "</tr>";
														}
													}
													echo "</table>";
																						
													}
												if($user[0]['user_type']=='Student'){
													$studtop=mysql_query('select * from examresults where classlist in (select classlist_id from test_classlist where test_id = '.$finished[$i]['test_id'].');');
													if($studtop==NULL){
														echo"no one has taken the exam yet";
													}
													else{
													echo "<h1>EXAM RESULTS</h1>";
													echo "<table>";
													echo "<tr>";
													echo "<td>Student ID</td> <td>Score</td>";
													echo "</tr>";
													for($i = 0; $i<10; $i++){
														while ($item = mysql_fetch_array($studtop)) {
															echo "<tr>";
															echo "<td> {$item[0]}</td> <td>{$item[1]}</td>";
															echo "</tr>";
														}
													}
													}
												}
											?>
											
										</div>
										<div class="modal-header">
											<a href="#" class="btn btn-primary" data-dismiss = "modal" onclick="okClicked();">OK</a>
										</div>		
					</div>

									

<script>
function confirm_delete(){
	return confirm('Are you sure you want to delete this test?');
};
</script>