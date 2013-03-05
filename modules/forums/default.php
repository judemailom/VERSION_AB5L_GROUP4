<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	unset($_SESSION['forum_id']);
	$USER = performQuery( "SELECT * FROM user WHERE user_uname='".$_SESSION['user']."';");
//	echo 'SELECT * FROM forum_members WHERE forum_user_id='.$USER[0]['user_id'].';';
	if($USER[0]['user_type'] == 'Student')
		$userForums = performQuery('SELECT * FROM forum_members WHERE forum_user_id='.$USER[0]['user_id'].';');
	else
		$userForums = performQuery('SELECT * FROM forum WHERE forum_author_id = '.$USER[0]['user_id'].';');
	if(isset($_GET['func']) && $_GET['func']=='create_forum'){
		include 'js/add_forum.js';
		unset($_GET['func']);
	}
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
	if(isset($_POST['enter_forum'])){
		$_SESSION['forum_id'] = $_POST['forum_id'];
		header('location: ?page=enter_forum');
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
?>	
<div id="add_forum" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="add_forum" aria-hidden="true">	
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Create New Forum</h4>
	</div>
	<div class="modal-body">
		<form action = "?page=forums" method="post" onsubmit="okClicked();">
		<div class="input-prepend">
		  <span class="add-on"><i class="icon-tags"></i></span>
		  <input class="span10" name="forum_name" id="prependedInput" type="text" placeholder="Forum title..." required="required" />
		</div>
		<div class="input-prepend">
		   <span class="add-on"><i class="icon-list"></i></span>
		  <input class="span10" name="forum_desc" id="prependedInput" type="text" placeholder="Forum description..." required="required" />
		</div>
			You may edit the members after creation.
	</div>
	<div class="modal-footer">
			<input type="submit" value="Create forum" name="create_forum" />
		</form>
	</div>
</div>
<?php 
if(isset($_SESSION['success']) && $_SESSION['success']>=1){ ?>
	<div class="alert alert-success">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Congratulations!</strong> Successfully <?php echo $_SESSION['mode']; ?> a forum.
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
<div id="forums">
	<div class="row-fluid">
		<div class="span12">
			<div class="containerDiv">
				<table class="table table-striped">
					<tr>
						<th>Forum name</th>
						<th>Description</th>
						<th colspan="3">Actions</th>
					</tr>
					<?php if($USER[0]['user_type']=='Teacher'){ ?>
						<tr id = "create">
							<td colspan="5" id="create"><a name="create" id="create" href="?page=forums&&func=create_forum">&plus; Create new forum...</a></td>
						</tr>
					<?php } ?>
					<?php
						if(!isset($userForums->num_rows)){	
							for($i=0; $i<sizeof($userForums);$i++){ 
									$myForums = performQuery('SELECT * FROM forum WHERE forum_id = '.$userForums[$i]['forum_id'].';');
									if(!isset($myForums->num_rows)){
							?>
								<tr>
									<td><?php	echo $myForums[0]['forum_name'];?></td>
									<td><?php	echo $myForums[0]['forum_description'];?></td>
									<td>
										<form action="" method="post">
											<input type="submit" class="action" value="Enter forum" name="enter_forum" />
											<input type="hidden" value="<?php echo $myForums[0]['forum_id']; ?>" name="forum_id" />
										</form>
									</td>
									<?php
										if($_SESSION['user_type']=='Teacher'){	?>
									<td>
										<form action="" method="post">
											<input type="submit" class="action" value="Edit members" name="edit_forum" />
											<input type="hidden" value="<?php echo $myForums[0]['forum_id']; ?>" name="forum_id" />
										</form>
									</td>
									<td>
										<form action="" method="post" onSubmit="return confirm_delete();">
											<input type="hidden" value="<?php echo $myForums[0]['forum_id']; ?>" name="forum_id" />
											<input type="submit" class="action" value="Delete forum" name="delete_forum" />
										</form>
									</td>
									<?php } ?>
									</td>
								</tr>
					<?php		}
							}
						}
						else{
							if($USER[0]['user_type'] == 'Student'){ ?>
								<tr><td colspan="3">You are not a member of any forum. You can search for a forum in the search bar and ask to join.</td></tr>
						<?php	}
							else{	?>
								<tr><td colspan="3">You do not own a forum. You can create a forum by clicking Create Forum above.</td></tr>
						<?php	}
						}	?>
				</table>
			</div>	
			
		</div>	
	</div>
</div>
<script>
function confirm_delete(){
	return confirm('Ar you sure you want to delete this forum?');
}
</script>