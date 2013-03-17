<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');

	if(isset($_POST['enter_forum'])){
		$_SESSION['forum_id'] = $_POST['forum_id'];
		header('location: ?page=enter_forum');
	} 
?>
	
<div class="row-fluid">
		<div class="span9">
			<div class="well">
			<?php
		//	var_dump($_POST);
			if(isset($_POST['search']) || isset($_SESSION['joined'])){
				if(isset($_POST['search']))
					$_SESSION['search_key'] = $_POST['search_key'];
				$key = $_SESSION['search_key'];
				if(isset($_SESSION['joined']) && $_SESSION['joined']==1){
					unset($_SESSION['joined']);
					unset($_SESSION['search_key']);
				}
			//	var_dump($_SESSION);
				if($_SESSION['user_type']!='Administrator')
					$q = 'SELECT * FROM forum WHERE (forum_name like "%'.$key.'%" or forum_description like "%'.$key.'%") AND forum_author_id IN (SELECT teacher_id FROM teacher WHERE teacher_school_name = "'.$_SESSION['user_school'].'");';
				else
					$q = 'SELECT * FROM forum WHERE (forum_name like "%'.$key.'%" or forum_description like "%'.$key.'%");';

			//	echo $q;
				$s_result = performQuery($q);
			//	var_dump($s_result);
				//$s_result = performQuery('SELECT * FROM forum WHERE forum_name like "%'.$_POST['search_key'].'%" or forum_description like "%'.$_POST['search_key'].'%";');
				if($s_result){
					if(!isset($s_result->num_rows)){ ?>
						<table class="table table-striped">
						<tr>
							<th>Forum Name</th>
							<th>Forum Author</th>
							<th>Forum Description</th>
							<th colspan="3">Actions</th>
						</tr>
						<?php
							for($i=0;$i<sizeof($s_result);$i++){ 
								$member = performQuery('SELECT * FROM user WHERE user_id IN (SELECT forum_user_id FROM forum_members WHERE forum_id='.$s_result[$i]['forum_id'].' and forum_user_id = '.$_SESSION['user_id'].') OR user_id IN (SELECT forum_author_id FROM forum WHERE forum_author_id = '.$_SESSION['user_id'].' AND forum_id='.$s_result[$i]['forum_id'].');');
								$author = performQuery('SELECT * FROM forum WHERE forum_id='.$s_result[$i]['forum_id'].' AND forum_author_id='.$_SESSION['user_id'].';');
								$author_type = performQuery('SELECT user_type FROM user WHERE user_id = (SELECT forum_author_id FROM forum WHERE forum_id = '.$s_result[$i]['forum_id'].');');
								$author_name = performQuery("SELECT user_uname, user_fname FROM user WHERE user_id = ".$s_result[$i]['forum_author_id'].";");
					
							?>
							<tr>
								<td><?php echo $s_result[$i]['forum_name']; ?></td>
								<td><?php echo $author_name[0]['user_fname'].' (@'.$author_name[0]['user_uname'].')';?></td>
								<td><?php echo $s_result[$i]['forum_description']; ?></td>
								<?php 
									//if user is a member or  author of the forum -> display option "enter forum"
									//var_dump($author_type);
									if($_SESSION['user_type']!='Administrator' && isset($member->num_rows)){ ?>
										<!--------------------------------------FORM KEY MODAL---------------------------------------->
											<div id="forum_key<?php echo $i; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="forum_key" aria-hidden="true">	
												<form action = "check_forum_key.php" method="POST" onsubmit="return validate_forum_key(this);">	
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														<h4>Please enter forum key</h4>
													</div>
													<div class="modal-body">
														<div class="forum_key_class"></div>
														<div class="input-prepend">
														  <span class="add-on"><i class="icon-check"></i></span>
														  <input class="span10" name="forum_key" id="prependedInput" type="text" placeholder="Forum key..." required="required" />
														</div>
													</div>
													<div class="modal-footer">
														<input type="submit" value="Join forum" name="join_forum" />
														<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" class="action"/>
													</div>
												</form>
											</div>
										<!--------------------------------------FORM KEY MODAL---------------------------------------->
										<td>
											<form action="" method="POST">
												<a name="forum_key" data-toggle="modal" title="Join this forum" id="forum_key" href="#forum_key<?php echo $i; ?>"><i class="icon-plus"></i></a>
											</form>
										</td>
								<?php	} 

									if($_SESSION['user_type']=='Administrator' || !isset($member->num_rows)){ ?>
										<td>
										<form action="" method="POST">
											<input type="submit" title="Enter this forum" value="" name="enter_forum" class="action enter"/>
											<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" class="action"/>
										</form>
										</td>
									<?php }
									
									if( ($author_type[0]['user_type'] == 'Teacher' && $_SESSION['user_type']=='Administrator') ||
										($author_type[0]['user_type'] == 'Administrator' && $_SESSION['user_type']=='Administrator' && !isset($author->num_rows) ) || 
										($author_type[0]['user_type'] == 'Teacher' && $_SESSION['user_type']=='Teacher' && !isset($author->num_rows) ) ){ ?>
										<td>
											<form action="" method="POST">
												<input type="submit" title="Edit members of this forum" class="action edit" value="" name="edit_forum" />
												<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" />
											</form>
										</td>
										<td>
											<form action="" method="POST" onSubmit="return confirm_delete();">
												<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" />
												<input type="submit"  title="Delete this forum" class="action delete" value="" name="delete_forum" />
											</form>
										</td>
								<?php	} else{ ?>
										<td>&minus;</td>
										<td>&minus;</td>
								<?php } ?>	
							</tr>	
						<?php	}	?>
						</table>
				<?php	} else{ ?>
					<table class="table table-striped">
						<tr><th>Your search did not match any results.
						</th></tr>
					</table>
				<?php	}
				}
			}
		?>
		</div>
	</div>
</div>
