<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	if(isset($_SESSION['post_comment_success'])){
		unset($_SESSION['post_comment_success']);
	}
	if(isset($_POST['post_comment'])){
			$a = performQuery('CALL add_comment("", '.$_SESSION['forum_id'].', '.$_SESSION['user_id'].', '.date('Y-m-d').', "'.$_POST['post_content'].'");');
			//var_dump($a);
			$_SESSION['post_comment_success'] = 1;
			header('location: #comment'.$a[0]['last_insert_id()'].'');
			//TO AVOID DOUBLE COMMENTS WHEN REFRESHED - Destroy $_POST variables
	}
	if(isset($_POST['delete_comment'])){
		echo 'DAKAKU';
	}
	$content = performQuery('SELECT * FROM forum_posts WHERE forum_id='.$_SESSION['forum_id'].' ORDER BY forum_posts_id;');
	$forum =  performQuery('SELECT * FROM forum WHERE forum_id='.$_SESSION['forum_id'].';');
	
?>
	<div class="well">
		<h4><?php echo $forum[0]['forum_name']; ?></h4>
		<h6><?php echo $forum[0]['forum_description']; ?></h6>
	</div>
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
								<?php	if($_SESSION['user_id'] == $content[$i]['forum_post_author_id']){ ?>
									<input type="submit" name="delete_comment" class="close" onClick="return confirm_del();" value="&times;">
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
<script>
	function confirm_del(){
		return confirm('Are you sure you want to delete this comment?');
	};
</script>