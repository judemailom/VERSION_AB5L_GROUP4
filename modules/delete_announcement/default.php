<?php
	require_once "includes/query.php";
	require_once "includes/connect.php";
	require_once "includes/use_db.php";
	//get user information
	$query =  'select * from user where user_uname = "'.$_SESSION['user'].'";';
	$r = performQuery($query);
	$user_type = $r[0]['user_type'];

	if($user_type == 'Student')
		header("Location: ?page=home");	
?>
<!-- DELETE ANNOUNCEMENT -->
<?php
	require_once "includes/connect.php";
	require_once "includes/use_db.php";

	//if delete button is selected
	if(isset($_POST['delete'])){
		require_once "includes/query.php";

		//save user information to variables
		$announcement_id = $_POST['announcement_id'];
		$announcement_title = $_POST['announcement_title'];
		$announcement_content = $_POST['announcement_content'];

		//delete from database
		$delete_announcement = "delete from announcement where announcement_id=".$announcement_id.";";
						
		$result1 = performQuery($delete_announcement);
		//set announcement_deleted to true for alert
		$_SESSION['announcement_deleted'] = true;
					
		if (!$result1) {
			//set announcement_deleted to false for alert
			$_SESSION['announcement_deleted'] = false;
			echo "Could not successfully run query {$delete_announcement} from DB: " . mysql_error();
			exit;
		}
	
		unset($_POST);
		//go back to add announcement page
		header("Location: ?page=home");	
		include "includes/close.php";
	}

	//if cancel button is selected
	elseif(isset($_POST['cancel'])){
		//go back to add announcement page
		header("Location: ?page=home");	
		include "includes/close.php";
	}
?>
<!-- End of Delete Announcement php -->

<!-- Delete Announcement -->
<div id="deleteannounce" >
	<div class="row-fluid" id="delete_announcement">
		<div id="delete_header">
			<h3 id="deletesure"> Are you sure you want to delete this announcement? </h4>
		</div>
		<form method="post">
			<div class="span9 announcement" id="delete_body">
				<input type="hidden" class="edit_announcement_text" <?php echo ' value="'.$_POST['announcement_id'].'" ';?> name="announcement_id" id="announcement_id"/>
				<div class="header">
					<?php echo $_POST['announcement_title'] ?>
				</div>
				<br/>
				<div id="divContent" class="content edit_announcement_text">
					<p  id="announce_content">
						<?php echo $_POST['announcement_content'] ?>
					</p>
				</div>
				<div class="span10">
					<table class="body righty">
						<tr>
							<td>
								<input type="submit" id="cancel" name="cancel" value="Cancel" class="button" />
							</td><td></td><td></td><td></td><td></td><td></td><td></td><td>
								<input type="submit" id="delete" name="delete" value="Delete" class="button" />
							</td>
						</tr>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End of delete Announcement -->