<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	$member_id = performQuery('SELECT forum_user_id FROM forum_members WHERE forum_id='.$_SESSION['forum_id'].';');
	//var_dump($_SESSION);
	if(isset($_GET['func']) && $_GET['func'] = 'add_members'){
		include 'js/add_members.js';
		unset($_GET['func']);
	}
	if(isset($_POST['add_selected_students'])){
		if(isset($_POST['students_to_be_added'])){
			for($i=0;$i<sizeof($_POST['students_to_be_added']);$i++){
				$user_id = performQuery('SELECT user_id FROM user WHERE user_fname = "'.$_POST['students_to_be_added'][$i].'";');
				$success = performQuery('INSERT INTO forum_members VALUES('.$_SESSION['forum_id'].', '.$user_id[0]['user_id'].');');
				if($success){
					$_SESSION['counter'] = 2;
					$_SESSION['status']='success';
					$_SESSION['mode']='added';
					$_SESSION['item']='member';
				}
				else
					$_SESSION['status']='failed';
				header('location: #');
			}
			unset($_POST['add_selected_students']);
		}
	}
	if(isset($_POST['remove_member'])){
		$a=performQuery('DELETE FROM forum_members WHERE forum_id='.$_SESSION['forum_id'].' AND forum_user_id='.$_POST['member_id'].';');
		if($a){
			$_SESSION['counter'] = 2;
			$_SESSION['status']='success';
			$_SESSION['mode']='removed';
			$_SESSION['item']='member';
		}
		else
			$_SESSION['success']=0;
		header('location: ?page=edit_forum_members');
	}
	if($_SESSION['user_type']!='Student'){
?>

<!--------------------------------------------------------BEGIN MODAL EDIT STUDENTS ------------------------------------------------------------>
<div id="ADD" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="add_students" aria-hidden="true">
	<form action="?page=edit_forum_members" method="post" onSubmit="okClicked();">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Add Members</h3>
		</div>
		<div class="modal-body">
				<?php 
					if($_SESSION['user_type']=='Teacher'){
						$classlists = performQuery('SELECT * FROM classlist WHERE classlist_author_id = '.$_SESSION['user_id'].';');
						if(!isset($classlists->num_rows)){
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
					}
					else if ($_SESSION['user_type'] == 'Administrator'){
						$list_of_admin = performQuery('SELECT * FROM user WHERE user_id IN (SELECT admin_id FROM admin WHERE admin_id != '.$_SESSION['user_id'].');');
						if(!isset($list_of_admin->num_rows)){ ?>
							<div class="tabbable tabs-left">
							  <ul class="nav nav-tabs">
								<li class="active">
									<a href="#admin" data-toggle="tab">List of Admininstrators</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="admin">
										<div class="row-fluid">
											<?php
												for($j=0;$j<sizeof($list_of_admin);$j++){
												//var_dump($list_of_admin[$j]);
											?>
											<label class="checkbox">
												<?php	$already_exists = performQuery('SELECT * FROM user WHERE user_id IN (SELECT forum_user_id FROM forum_members WHERE forum_user_id = '.$list_of_admin[$j]['user_id'].' and forum_id = '.$_SESSION['forum_id'].');'); ?>
												<input type="checkbox" <?php echo isset($already_exists->num_rows)?'':'disabled="disabled"'; ?> value="<?php echo $list_of_admin[$j]['user_fname']; ?>" name="students_to_be_added[]">
												<?php echo $list_of_admin[$j]['user_fname']; ?>
											</label>
											<?php } ?>
										</div>
								</div>
							  </div>
							</div>
					<?php	}
					}
				?>
		</div>
		<div class="modal-header">
					<input type="submit" value="<?php echo isset($classlists->num_rows)?'Ok':'Add Selected Students'?>" name="add_selected_students" />
		</div>
	</form>
</div>
<!-------------------------------------------------------------END MODAL EDIT STUDENTS ---------------------------------------------------------->
<?php	
	} ?>
		<div class="row-fluid">
			<div class="span9">
				<?php 
			if(isset($_SESSION['counter'])){
				if( $_SESSION['counter']<2 && $_SESSION['counter']>=0){
					if(isset($_SESSION['status']) && $_SESSION['item'] == 'member'){
						$status=$_SESSION["status"];
						$mode=$_SESSION["mode"];
						$item=$_SESSION["item"];
						include 'includes/alert.php';
						unset($_SESSION['status']);
						unset($_SESSION['item']);
						unset($_SESSION['mode']);
					}
				}
				else if($_SESSION['counter'] == 2)
					$_SESSION['counter'] -=1;
				else
					unset($_SESSION['counter']);
			}
			?>
			<div class="well">
				<?php $forum =  performQuery('SELECT * FROM forum WHERE forum_id='.$_SESSION['forum_id'].';'); ?>
				<h4><?php echo $forum[0]['forum_name']; ?></h4>
				<h6><?php echo $forum[0]['forum_description']; ?></h6>
			</div>
			<div class="well">
				<table class="table table-striped">
					<tr>
						<th>Name</th>
						<th>Username</th>
						<th>From classlist(s)</th>
						<th>Actions</th>
					</tr>
					<?php
						$own = performQuery('SELECT * FROM forum WHERE forum_id = '.$_SESSION['forum_id'].' AND forum_author_id = '.$_SESSION['user_id'].';');
						//var_dump($own);
						if(!isset($own->num_rows)){
					?>
							<tr id = "create" class="center-aligned">
								<td colspan="4" id="create">
									<a name="create" data-toggle="modal" id="create" href="#ADD">&plus; Add members...</a>
								</td>
							</tr>
						<?php 
						}
						if(!isset($member_id->num_rows)){
						//	var_dump($member_id);
						for($i=0;$i<sizeof($member_id);$i++){ 
							$user =  performQuery('SELECT * FROM user WHERE user_id = '.$member_id[$i]['forum_user_id'].';');
						?>
								<tr class="center-aligned">
									<td><?php echo $user[0]['user_fname']?></td>
									<td><?php echo $user[0]['user_uname']?></td>
									<td><?php echo $user[0]['user_uname']?></td>
									<td><form action="?page=edit_forum_members" method="post" onsubmit="return confirm_remove();">
										<input type="submit" value="" name="remove_member" class="action delete" />
										<input type="hidden" value="<?php echo $user[0]['user_id']; ?>" name="member_id" />
									</form></td>
								</tr>
							
						<?php	} 
							}
					else {?>
							<tr><td colspan="4">This forum is empty. Click Add Members if you wish to add students in your classlists to this forum.</td></tr>
					<?php } ?>
				</table>
			</div>
		</div>
		</div>

<script>
	function confirm_remove(){
		return confirm('Are you sure you want to remove this member from the forum? However, his/her comments will not be removed from the forum.');
	}
</script>