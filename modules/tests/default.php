<?php
	if(isset($_POST['view_test'])){
		//echo $_POST['test_id'];
		header('location: ?page=view_test&&test_id='.$_POST['test_id'].'');
	}
?>
<div id="test">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<div class="row-fluid">
					</div class="span12">
						<?php 
						$user = performQuery('SELECT * FROM user WHERE user_uname = "'.$_SESSION['user'].'"');
						if($user[0]['user_type']=='Teacher'){
						?>
						<form action="?page=add_test" method="post">
							<input type="submit" value="Create a test" />
						</form>
						<?php } ?>
					</div>
				</div>
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
				<?php
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
						<form action="" method="post">
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
								<input type="hidden" value="<?php echo $unfinished[$i]['test_id']; ?>" name="test_id"/>		
						</td>
						<?php } ?>
						</form>
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