<?php
	$school_forums = performQuery("SELECT f.forum_name, f.forum_id, f.forum_description, f.forum_author_id, t.teacher_school_name FROM forum f, teacher t WHERE f.forum_author_id = t.teacher_id ORDER BY t.teacher_school_name;");
	$admin_forums = performQuery("SELECT * FROM forum WHERE forum_author_id IN (SELECT admin_id FROM admin);");
	//var_dump($school_forums);
	if(isset($_POST['enter_forum'])){
		$_SESSION['forum_id'] = $_POST['forum_id'];
		header('location: ?page=enter_forum');
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
	if(isset($_POST['join_forum'])){
		$a = performQuery('INSERT INTO forum_members VALUES('.$_POST['forum_id'].', '.$_SESSION['user_id'].')');
		if($a){
				$_SESSION['success']=2;
				$_SESSION['mode'] = 'joined';
			}
			else
				$_SESSION['success']=0;
			header('location: #');
	} 

?>
<div class="row-fluid">
	<div id="manage_forums" class="span9">
		<div class="well">
			<h5>Administrator Forums</h5>
			<table id="admin_forums" class="table table-striped">
					<th>Forum Name</th>
					<th>Forum Description</th>
					<th>Author</th>
					<th colspan="3">Actions</th>
				<?php
				if(!isset($admin_forums->num_rows)){
					for($i=0; $i<sizeof($admin_forums);$i++){
					
					$author = performQuery("SELECT user_uname, user_fname FROM user WHERE user_id = ".$admin_forums[$i]['forum_author_id'].";");
					$member_of = performQuery('SELECT * FROM forum_members WHERE forum_id='.$admin_forums[$i]['forum_id'].' AND forum_user_id = '.$_SESSION['user_id'].';');
					$author_of = performQuery('SELECT * FROM forum WHERE forum_author_id = '.$_SESSION['user_id'].' AND forum_id='.$admin_forums[$i]['forum_id'].';');
					//var_dump($author_of);
					?>
						<tr>
							<td><?php echo $admin_forums[$i]['forum_name']; ?></td>
							<td><?php echo $admin_forums[$i]['forum_description']; ?></td>
							<td><?php echo $author[0]['user_fname'].' (@'.$author[0]['user_uname'].')';?></td>

							<?php if(isset($author_of->num_rows) && isset($member_of->num_rows)){ ?>
								<td>
									<form action="" method="post">
										<input type="submit" value="" name="join_forum" class="action join"/>
										<input type="hidden" value="<?php echo $admin_forums[$i]['forum_id']; ?>" name="forum_id" class="action"/>
									</form>
								</td>
							<?php } ?>

						<?php if(!isset($author_of->num_rows) || !isset($member_of->num_rows)){ ?>
							<td>
								<form action="" method="post">
									<input type="submit" value="" name="enter_forum" class="action enter"/>
									<input type="hidden" value="<?php echo $admin_forums[$i]['forum_id']; ?>" name="forum_id" class="action"/>
								</form>
							</td>
						<?php } 
							if(!isset($author_of->num_rows)){ ?>
							<td>
								<form action="" method="post">
									<input type="submit" value="" name="edit_forum" class="action edit"/>
									<input type="hidden" value="<?php echo $admin_forums[$i]['forum_id']; ?>" name="forum_id" class="action"/>
								</form>
							</td>
							<td>
								<form action="" method="post" onsubmit="return confirm_delete();">
									<input type="submit" value="" name="delete_forum" class="action delete"/>
									<input type="hidden" value="<?php echo $admin_forums[$i]['forum_id']; ?>" name="forum_id" class="action"/>
								</form>
							</td>
							<?php }
							else { ?> 
								<td>&minus;</td>
								<td>&minus;</td>
							<?php } ?>
							
						</tr>
					<?php	} 
					}else{ ?>
						<tr><td colspan="6" class="center-aligned">There are no forums available.</td></tr>
					<?php } ?>
			</table>
		</div>
		<div class="well">
			<h5>School Forums</h5>
			<table id="school_forums" class="table table-striped">
					<th>School Name</th>
					<th>Forum Name</th>
					<th>Forum Description</th>
					<th>Author</th>
					<th colspan="3">Actions</th>
				<?php
				if(!isset($school_forums->num_rows)){
					for($i=0; $i<sizeof($school_forums);$i++){
					
					$author = performQuery("SELECT user_uname, user_fname FROM user WHERE user_id = ".$school_forums[$i]['forum_author_id'].";");?>
						<tr>
							<td><?php echo $school_forums[$i]['teacher_school_name']; ?></td>
							<td><?php echo $school_forums[$i]['forum_name']; ?></td>
							<td><?php echo $school_forums[$i]['forum_description']; ?></td>
							<td><?php echo $author[0]['user_fname'].' (@'.$author[0]['user_uname'].')';?></td>
							<td>
								<form action="" method="post">
									<input type="submit" value="" name="enter_forum" class="action enter"/>
									<input type="hidden" value="<?php echo $school_forums[$i]['forum_id']; ?>" name="forum_id" class="action"/>
								</form>
							</td>
							<td>
								<form action="" method="post">
									<input type="submit" value="" name="edit_forum" class="action edit"/>
									<input type="hidden" value="<?php echo $school_forums[$i]['forum_id']; ?>" name="forum_id" class="action"/>
								</form>
							</td>
							<td>
								<form action="" method="post" onsubmit="return confirm_delete();">
									<input type="submit" value="" name="delete_forum" class="action delete"/>
									<input type="hidden" value="<?php echo $school_forums[$i]['forum_id']; ?>" name="forum_id" class="action"/>
								</form>
							</td>
						</tr>
					<?php	} 
					}else{ ?>
						<tr><td colspan="6" class="center-aligned">There are no forums available.</td></tr>
					<?php } ?>
			</table>
		</div>
	</div>
</div>
<script>
function confirm_delete(){
	return confirm('Are you sure you want to delete this forum?');
}
</script>