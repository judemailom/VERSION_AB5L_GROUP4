<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	if(isset($_POST['enter_forum'])){
		$_SESSION['forum_id'] = $_POST['forum_id'];
		header('location: ?page=enter_forum');
	}
	if(isset($_POST['join_forum'])){
		$a = performQuery('INSERT INTO forum_members VALUES('.$_POST['forum_id'].', '.$_SESSION['user_id'].')');
		if($a){
				$_SESSION['success']=4;
				$_SESSION['mode'] = 'joined';
			}
			else
				$_SESSION['success']=0;
			$_SESSION['joined'] = 1;
			header('location: #');
	} ?>
<div class="row-fluid">
		<div class="span9">
			<div class="well center-aligned">
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
							<th>Forum Description</th>
							<th colspan="3">Actions</th>
						</tr>
						<?php
							for($i=0;$i<sizeof($s_result);$i++){ 
							?>
							<tr>
								<td><?php echo $s_result[$i]['forum_name']; ?></td>
								<td><?php echo $s_result[$i]['forum_description']; ?></td>
								<td><?php 
									//if user is a member or  author of the forum -> display option "enter forum"
									$member = performQuery('SELECT * FROM user WHERE user_id IN (SELECT forum_user_id FROM forum_members WHERE forum_id='.$s_result[$i]['forum_id'].' and forum_user_id = '.$_SESSION['user_id'].') OR user_id IN (SELECT forum_author_id FROM forum WHERE forum_author_id = '.$_SESSION['user_id'].' AND forum_id='.$s_result[$i]['forum_id'].');');
									if(!isset($member->num_rows)){ ?>
										<form action="" method="post">
											<input type="submit" value="" name="enter_forum" class="action enter"/>
											<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" class="action"/>
										</form>
										<td>
											<form action="" method="post">
												<input type="submit" class="action edit" value="" name="edit_forum" />
												<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" />
											</form>
										</td>
										<td>
											<form action="" method="post" onSubmit="return confirm_delete();">
												<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" />
												<input type="submit" class="action delete" value="" name="delete_forum" />
											</form>
										</td>
								<?php	}
									else{ ?>
										<td>
											<form action="" method="post">
												<input type="submit" value="" name="join_forum" class="action join"/>
												<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" class="action"/>
										</td>
										<td></td>
								<?php	}
								?></td>
							</tr>	
						<?php	}
						?>
						
						</table>
			<?php		}
					else{ ?>
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