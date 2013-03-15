<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	if(isset($_SESSION['post_comment_success'])){
		unset($_SESSION['post_comment_success']);
	}
	if(isset($_POST['post_comment'])){
			$date = date('Y-m-d');
			$a = performQuery('CALL add_comment("", '.$_SESSION['forum_id'].', '.$_SESSION['user_id'].', "'.$date.'", "'.$_POST['post_content'].'");');
			//var_dump($a);
			$_SESSION['post_comment_success'] = 1;
			header('location: #comment'.$a[0]['last_insert_id()'].'');
			//TO AVOID DOUBLE COMMENTS WHEN REFRESHED - Destroy $_POST variables
	}
	if(isset($_GET['comment_id'])){
		$delete = performQuery('DELETE FROM forum_posts WHERE forum_posts_id = '.$_GET['comment_id'].' AND forum_id='.$_GET['forum_id'].';');
		if($delete){
			$_SESSION['success']=4;
			$_SESSION['mode'] = 'deleted';
		}
		else
			$_SESSION['success']=0;
		header('location: ?page=enter_forum&&forum_id='.$_GET['forum_id'].'');
	}
	$content = performQuery('SELECT * FROM forum_posts WHERE forum_id='.$_SESSION['forum_id'].' ORDER BY forum_posts_id;');
	$forum =  performQuery('SELECT * FROM forum WHERE forum_id='.$_SESSION['forum_id'].';');
	
?>
	<div class="row-fluid">
		<div class="span9" id="div_forums">
			<div class="well">
				<h4><?php echo $forum[0]['forum_name']; ?></h4>
				<h6><?php echo $forum[0]['forum_description']; ?></h6>
			</div>
			
			<?php 
			if(isset($_SESSION['success']) && $_SESSION['success']>=1 && $_SESSION['mode']=='deleted'){ ?>
				<div class="alert alert-success">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  <strong>Congratulations!</strong> Successfully deleted the comment.
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
				if(($_SESSION['success']==1 || $_SESSION['success']<0))
					unset($_SESSION['success']);
				else
					$_SESSION['success']-=1;
			}
			?>
			<table class="table table-striped">
		<?php	if(isset($content->num_rows)){ ?>
					<tr><td>No posts in this forum yet.	</td></tr>
		<?php
				}
			else{
				for($i=0;$i<sizeof($content);$i++){	
				$user_fname = performQuery('SELECT user_fname FROM user WHERE user_id = "'.$content[$i]['forum_post_author_id'].'";');
				//var_dump($user_fname);
				?>		
				<tr id="comment<?php echo $content[$i]['forum_posts_id']; ?>">
					<td>
						<form method="post" action="">
							<?php	if($_SESSION['user_id'] == $content[$i]['forum_post_author_id'] || $_SESSION['user_type']=='Administrator'){ ?>
								<a name="delete_comment" class="close" href="?page=enter_forum&&forum_id=<?php echo $_SESSION['forum_id'];?>&&comment_id=<?php echo $content[$i]['forum_posts_id'] ;?>" onClick="return confirm_del();">&times;</a>
							<?php } ?>
							<h6><?php echo $user_fname[0]['user_fname']?> said:</h6>
							<?php echo $content[$i]['forum_post_content']; ?>
							<p class="date_posted">Posted: <?php echo $content[$i]['forum_post_date']; ?></p>
						</form>
					</td>
				</tr>
		<?php	}
			} 
		?>
			<tr><td>
				<form action="" method="post">
					<div class="container-fluid">
						<div class="row-fluid">
							<div class="span11">
								<textarea name="post_content" rows="3" placeholder="Write a comment..."></textarea>
							</div>
							<div class="span1">
								<input type="submit" value="Post" name="post_comment" />
							</div>
						</div>
					</div>
				</form>
			</td></tr>
			</table>
		</div>
	</div>
<script>
	function confirm_del(){
		return confirm('Are you sure you want to delete this comment?');
	};
</script>