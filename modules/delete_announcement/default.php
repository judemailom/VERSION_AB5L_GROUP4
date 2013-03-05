<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<!-- DELETE ANNOUNCEMENT -->
<?php
	require_once "includes/connect.php";
	require_once "includes/use_db.php";

	if(isset($_POST['delete'])){
		require_once "includes/query.php";	
		//save
		$announcement_id = $_POST['announcement_id'];
		$announcement_title = $_POST['announcement_title'];
		$announcement_content = $_POST['announcement_content'];

		$delete_announcement = "delete from announcement where announcement_id=".$announcement_id.";";
						
		$result1 = performQuery($delete_announcement);
					
		if (!$result1) {
			echo "Could not successfully run query {$delete_announcement} from DB: " . mysql_error();
			exit;
		}
	
		unset($_POST);
		header("Location: ?page=add_announcement");	

		include "includes/close.php";
	}

	elseif(isset($_POST['cancel'])){
		header("Location: ?page=add_announcement");	
		include "includes/close.php";
	}
?>
<!-- End of Delete Announcement php -->

<?php
	require_once "includes/query.php";

	$query =  'select user_type from user where user_uname = "'.$_SESSION['user'].'";';
	$r = performQuery($query);
	$user_type = $r[0]['user_type'];
	$r = performQuery('select '.$user_type.'_school_name from '.$user_type.' where '.$user_type.'_id = (select user_id from user where user_uname = "'.$_SESSION['user'].'");');
	$user_school = $r[0][$user_type.'_school_name'];
//	$announcements = performQuery('select * from announcement where author_id = (select teacher_id from teacher where teacher_school_name="'.$user_school.'" group by teacher_school_name);');
//	var_dump($announcements);

	$query = "select * from user where user_uname = '{$_SESSION['user']}'";	
	$r = performQuery($query);

	$announcements = performQuery('select * from announcement;')
?>

<div id="delete_announcement">
	<div class="row-fluid">
		<h4 id="deletesure"> Are you sure you want to delete this announcement? </h4>
		<form method="post">
		<div class="span9 announcement">
			<input type="hidden" class="edit_announcement_text" <?php echo ' value="'.$_POST['announcement_id'].'" ';?> name="announcement_id" id="announcement_id"/>
			<div class="header">
				<?php echo $_POST['announcement_title'] ?>
			</div>
			<div id="divContent" class="content">
				<p  id="announce_content" >
					<?php echo $_POST['announcement_content'] ?>
				</p>
			</div>
			<input type="submit" id="delete" name="delete" value="Delete" class="button righty" />
			<input type="submit" id="cancel" name="cancel" value="Cancel" class="button righty" />
		</div>
	</form>
	</div>
</div>