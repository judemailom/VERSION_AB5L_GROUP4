<!-- EDIT ANNOUNCEMENT -->
<?php
	require_once "includes/connect.php";
	require_once "includes/use_db.php";

	//if save changes button is selected
	if(isset($_POST['save_changes'])){
		require_once "includes/query.php";

		//save user information into variables
		$announcement_id = $_POST['announcement_id'];
		$announcement_title = $_POST['announcement_title'];
		$announcement_content = $_POST['announcement_content'];

		//update database
		$update_announcement = "update announcement set announcement_title ='".$announcement_title."',announcement_content ='".
								$announcement_content."' where announcement_id=".$announcement_id.";";
						
		$result1 = performQuery($update_announcement);
					
		if (!$result1) {
			echo "Could not successfully run query {$update_announcement} from DB: " . mysql_error();
			exit;
		}
	
		unset($_POST);
		//set announcement_edited to true for alert js
		$_SESSION['announcement_edited'] = true;
		//go back to add announcement page
		header("Location: ?page=home");	
		include "includes/close.php";
	}
	//if cancel button is selected
	elseif (isset($_POST['cancel'])) {
		unset($_POST);
		//go back to add announcement page
		header("Location: ?page=home");	
		include "includes/close.php";
	}
?>
<!-- End of Edit Announcement php -->

<!-- Edit Announcement -->
<div id="edit_announcement">
	<div class="row-fluid edit">
		<div class="span7">
			<h4 class="span7"> Edit Announcement </h>
		</div>
		<div class="span9 announcement">
			<br><br>
			<form method="post">
				<table>
					<tr>
						<td class="body" colspan="2">
							<input type="hidden" class="edit_announcement_text" <?php echo ' value="'.$_POST['announcement_id'].'" ';?> name="announcement_id" id="announcement_id"/>
						</td>
					</tr>
					<tr>
						<td class="body" colspan="2">
							<div class="header">
								Title:
							</div>
						</td>
						<td>
							<input type="text" class="edit_announcement_text" <?php echo ' value="'.$_POST['announcement_title'].'" ';?> placeholder="Title" name = "announcement_title" />
						</td>
					</tr>
					<tr>
						<td class="body" colspan="2">
							<div id="divContent" class="content">
								Content:
							</div>
						</td>
						<td>
							<textarea class="edit_announcement_text" resizable="false" rows="10" placeholder="Content" name = "announcement_content" > <?php echo $_POST['announcement_content'];?></textarea>
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
						</td>
						<td class="body righty" colspan="2">
							<input type="submit" id="save_changes" name="save_changes" value="Save Changes" class="button righty" />
						</td>
						<td class="body righty" colspan="2">
							<input type="submit" id="cancel" name="cancel" value="Cancel" class="button righty" />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
<!-- End of Edit Announcement -->