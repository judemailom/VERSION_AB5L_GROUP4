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
					
		if (!$result1) {
			echo "Could not successfully run query {$delete_announcement} from DB: " . mysql_error();
			exit;
		}
	
		unset($_POST);
		//set announcement_deleted to true for alert js
		$_SESSION['announcement_deleted'] = true;
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
<div id="deleteannounce">
	<div class="row-fluid" id="delete_announcement">
		<div class="span7">
			<h4 class="span7"> Delete Announcement </h>
		</div>
		<h4 id="deletesure"> Are you sure you want to delete this announcement? </h4>
		<form method="post">
			<div class="span9 announcement">
				<input type="hidden" class="edit_announcement_text" <?php echo ' value="'.$_POST['announcement_id'].'" ';?> name="announcement_id" id="announcement_id"/>
				<div class="header">
					<?php echo $_POST['announcement_title'] ?>
				</div>
				<div id="divContent" class="content edit_announcement_text">
					<p  id="announce_content">
						<?php echo $_POST['announcement_content'] ?>
					</p>
				</div>
				<div class="righty span12">
					<input type="submit" id="delete" name="delete" value="Delete" class="button righty" />
					<input type="submit" id="cancel" name="cancel" value="Cancel" class="button righty" />
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End of delete Announcement -->