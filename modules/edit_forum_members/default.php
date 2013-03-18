<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	$member_id = performQuery('SELECT forum_user_id FROM forum_members WHERE forum_id='.$_SESSION['forum_id'].';');
	//var_dump($_SESSION);
	if(isset($_GET['func']) && $_GET['func'] = 'add_members'){
		include 'js/add_members.js';
		$classlists = performQuery('SELECT * FROM classlist WHERE classlist_author_id = '.$_SESSION['user_id'].';');
		unset($_GET['func']);
	}
	if(isset($_POST['add_selected_students'])){
		if(isset($_POST['students_to_be_added'])){
			for($i=0;$i<sizeof($_POST['students_to_be_added']);$i++){
				$user_id = performQuery('SELECT user_id FROM user WHERE user_fname = "'.$_POST['students_to_be_added'][$i].'";');
				$success = performQuery('INSERT INTO forum_members VALUES('.$_SESSION['forum_id'].', '.$user_id[0]['user_id'].');');
				if($success){
					$_SESSION['success']=2;
					$_SESSION['mode']='added';
				}
				else
					$_SESSION['success']=0;
				header('location: ?page=edit_forum_members');
			}
			unset($_POST['add_selected_students']);
		}
	}
	if(isset($_POST['remove_member'])){
		$a=performQuery('DELETE FROM forum_members WHERE forum_id='.$_SESSION['forum_id'].' AND forum_user_id='.$_POST['member_id'].';');
		if($a){
			$_SESSION['success']=2;
			$_SESSION['mode']='deleted';
		}
		else
			$_SESSION['success']=0;
		header('location: ?page=edit_forum_members');
	}
	if($_SESSION['user_type']=='Teacher'){
?>
<?php 
if(isset($_SESSION['success']) && $_SESSION['success']>=1){ ?>
	<div class="alert alert-success">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Congratulations!</strong> Successfully <?php echo $_SESSION['mode']; ?> the student(s).
	</div>
<?php
}
else if(isset($_SESSION['success']) && $_SESSION['success']<0){ ?>
	<div class="alert alert-error">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Sorry!</strong> Something went wrong. Please try again. 
	</div>
<?php	}
if(isset($_SESSION['success'])){
	if(($_SESSION['success']==1 || $_SESSION['success']<0)){
		unset($_SESSION['success']);
		unset($_SESSION['mode']);
	}
	else
		$_SESSION['success']-=1;
}
?>
<div id="add_forum_members" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="invalid_login" aria-hidden="true">
	 <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Add Members</h3>
	</div>
	<div class="modal-body">
		<form action="?page=edit_forum_members" method="post" onSubmit="okClicked();">
			<?php	if(!isset($classlists->num_rows)){
				?>
			<div class="tabbable tabs-left">
			  <ul class="nav nav-tabs">
				<?php	for($i=0; $i<sizeof($classlists);$i++){	?>
				<li <?php echo $i==0?'class="active"':''; ?>>
					<a href="#<?php echo 'list'.$i; ?>" data-toggle="tab"><?php echo $classlists[$i]['classlist_name']; ?></a></li>
				<?php }	
				?>
			  </ul>
			  <div class="tab-content">
				<?php	for($i=0; $i<sizeof($classlists);$i++){	?>
				<div class="tab-pane <?php echo $i==0?'active':''; ?>" id="<?php echo 'list'.$i; ?>">
						<div class="row-fluid">
							<?php
								$members = performQuery('SELECT * FROM user WHERE user_id in (SELECT classlist_user_id FROM classlist_members WHERE classlist_id = '.$classlists[$i]['classlist_id'].');');
							//	var_dump($members);
								if(!isset($members->num_rows)){
									for($j=0;$j<sizeof($members);$j++){
							?>
							<label class="checkbox">
								<?php	$already_exists = performQuery('SELECT * FROM user WHERE user_id IN (SELECT forum_user_id FROM forum_members WHERE forum_user_id = '.$members[$j]['user_id'].' and forum_id = '.$_SESSION['forum_id'].');'); ?>
								<input type="checkbox" <?php echo isset($already_exists->num_rows)?'':'disabled="disabled"'; ?> value="<?php echo $members[$j]['user_fname']; ?>" name="students_to_be_added[]">
								<?php echo $members[$j]['user_fname']; ?>
							</label>
							<?php }	
							}
							else
								echo 'Classlist is empty.';
							?>
						</div>
				</div>
				<?php }			
				?>
			  </div>
			</div>
			<?php }
				else
					echo 'You currently have no classlist. ';
			?>
		</div>
		<div class="modal-header">
				<input type="submit" value="<?php echo isset($classlists->num_rows)?'Ok':'Add Selected Students'?>" name="add_selected_students" />
		</div>
	</form>
</div>
<?php	
	} ?>
			<table class="table table-striped">
				<tr>
					<th>Name</th>
					<th>Username</th>
					<th>From classlist(s)</th>
					<th>Actions</th>
				</tr>
				<tr id = "create">
					<td colspan="4" id="create"><a name="create" id="create" href="?page=edit_forum_members&&func=add_members">&plus; Add students...</a></td>
				</tr>
	<?php 
	if(!isset($member_id->num_rows)){
	//	var_dump($member_id);
	for($i=0;$i<sizeof($member_id);$i++){ 
		$user =  performQuery('SELECT * FROM user WHERE user_id = '.$member_id[$i]['forum_user_id'].';');
	?>
			<tr>
				<td><?php echo $user[0]['user_fname']?></td>
				<td><?php echo $user[0]['user_uname']?></td>
				<td><?php echo $user[0]['user_uname']?></td>
				<td><form action="?page=edit_forum_members" method="post" onsubmit="return confirm_remove();">
					<input type="submit" value="Remove member" name="remove_member" class="action" />
					<input type="hidden" value="<?php echo $user[0]['user_id']; ?>" name="member_id" />
				</form></td>
			</tr>
		
	<?php	} ?>
			</table>
	<?php }
	else {?>
		<tr><td colspan="4">This forum is empty. Click Add Members if you wish to add students in your classlists to this forum.</td></tr>
<?php } ?>
<script>
	function confirm_remove(){
		return confirm('Are you sure you want to remove this member from the forum? However, his/her comments will not be removed from the forum.');
	}
</script>