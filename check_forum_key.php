<?php
include_once 'includes/query.php';
session_start();

//var_dump($_POST);
$forum_key = performQuery('SELECT forum_key FROM forum WHERE forum_id = '.$_POST['forum_id'].';');
//var_dump($forum_key);
if($forum_key[0]['forum_key'] != $_POST['forum_key']) { ?>
	<div class="alert alert-error">
		Forum key is invalid. Please try again.
	</div>
<?php }
	else{ 
		//echo 'INSERT INTO forum_members VALUES('.$_POST['forum_id'].', '.$_SESSION['user_id'].')';
		$a = performQuery('INSERT INTO forum_members VALUES('.$_POST['forum_id'].', '.$_SESSION['user_id'].')');
		$_SESSION['forum_id'] = $_POST['forum_id'];
		//var_dump($_SESSION);
		if($a){
				$_SESSION['counter'] = 2;
				$_SESSION['status']='success';
				$_SESSION['mode']='joined';
				$_SESSION['item']='forum';
			}
			else
				$_SESSION['status']='failed';
		?>
		<script type="text/javascript">
			window.location = '?page=enter_forum';
		</script>
<?php } ?>

