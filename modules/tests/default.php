<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	if(isset($_POST['delete_test'])){
		$a = performQuery('CALL delete_test('.$_POST['test_id'].');');
		if($a)
			include 'js/delete_test.js';
	}
	if(isset($_GET['func']) && $_GET['func']=='add_test')
		header('location: ?page=add_test');
	$user = performQuery('SELECT * FROM user WHERE user_uname = "'.$_SESSION['user'].'"'); ?>
<div id="delete_test" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="delete_test" aria-hidden="true">	
	<div class="modal-header">
		<h3>Test successfully deleted!</h3>
	</div>
	<div class="modal-header">
		<a href="#" class="btn btn-primary" onclick="okClicked();">Go back to tests</a>
	</div>
</div>
<div id="test">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="row-fluid">
					<!--UNFINISHED TESTS-->
<div class="span12">
	Finished tests
</div>
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
				<form action="" method="post">
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
						<input type="submit" value="View top scorers" name="view_top_scorers" class="action"/>
				</td>						
				<?php
				if($user[0]['user_type']=='Teacher'){
				?>
				<td>
						<input type="submit" value="Delete test" name="delete_test" class="action"/>
				</td>
				<td>
						<input type="submit" value="View test" name="view_test" class="action"/>
				</td>
				<?php } ?>
					<input type="hidden" value="<?php echo $finished[$i]['test_id']; ?>" name="delete_test"/>		
				</form>
			<?php
				}
			}
			else{ ?>
				<tr><td colspan="6">No existing test in this category.</td></tr>
			<?php } ?>
		</tr>
	</table>


<!--UNFINISHED TESTS-->
<div class="row-fluid">
	<div class="span12">
		Unfinished tests
	</div>
</div>
<div class="row-fluid">
	</div class="span12">
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
						<td>
							<form action="" method="post">
								<input type="submit" value="View top scorers" name="view_top_scorers" class="action"/>
							</form>
						</td>						
						<?php
						if($user[0]['user_type']=='Teacher'){
						?>
						<td>
							<form action="" method="post" onsubmit="return confirm_delete();">
								<input type="submit" value="Delete test" name="delete_test" class="action"/>
								<input type="hidden" value="<?php echo $unfinished[$i]['test_id']; ?>" name="test_id" class="action"/>
							</form>
						</td>
						<td>
							<form action="?page=view_test&&test_id=<?php echo $unfinished[$i]['test_id']; ?>" method="post">
								<input type="submit" value="View test" name="view_test" class="action"/>
							</form>
						</td>
						<?php } ?>
					<?php
						}
					}else{ ?>
				<tr><td colspan="6">No existing test in this category.</td></tr>
			<?php } ?>
				</tr>
			</table>
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