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
				$_SESSION['success']=2;
				$_SESSION['mode'] = 'created';
			}
			else
				$_SESSION['success']=0;
			header('location: #');
	} ?>
<?php 
if(isset($_SESSION['success']) && $_SESSION['success']>=1){ ?>
	<div class="alert alert-success">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Congratulations!</strong> Successfully joined a forum.
	  <a class="btn" href="?page=forums">Go to forums</a>
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
<?php	if(isset($_POST['search'])){
	//	var_dump($_SESSION);
		$q = 'SELECT * FROM forum WHERE (forum_name like "%'.$_POST['search_key'].'%" or forum_description like "%'.$_POST['search_key'].'%") AND forum_author_id IN (SELECT teacher_id FROM teacher WHERE teacher_school_name = "'.$_SESSION['user_school'].'");';
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
					<th>Actions</th>
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
									<input type="submit" value="Enter forum" name="enter_forum" class="action"/>
									<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" class="action"/>
								</form>
						<?php	}
							else{ ?>
								<form action="" method="post">
									<input type="submit" value="Join forum" name="join_forum" class="action"/>
									<input type="hidden" value="<?php echo $s_result[$i]['forum_id']?>" name="forum_id" class="action"/>
								</form>
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