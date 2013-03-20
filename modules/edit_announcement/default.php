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
<!-- EDIT ANNOUNCEMENT -->
<?php
	require_once "includes/connect.php";
	require_once "includes/use_db.php";

	//if save changes button is selected
	if(isset($_POST['save_changes'])){
		require_once "includes/query.php";

		//get user information
		$query = "select * from user where user_uname = '{$_SESSION['user']}'";	
		$result = mysql_query($query, $con);
		$sid =  performQuery($query);

		//save user information into variables
		$announcement_id = $_POST['announcement_id'];
		$announcement_title = $_POST['announcement_title'];
		$announcement_content = $_POST['announcement_content'];

		//delete from database
		$delete_announcement = "delete from announcement where announcement_id=".$announcement_id.";";

		//insert announcement into database
		$new_announcement = "insert into announcement (announcement_author,author_id,announcement_date,announcement_title,announcement_content) 
						values(
							'{$sid[0]['user_fname']}',
							'{$sid[0]['user_id']}',
							NULL,
							'{$announcement_title}', 
							'{$announcement_content}'
						)";

		$result1 = performQuery($delete_announcement);
		$result2 = performQuery($new_announcement);	
		//set announcement_edited to true for alert
		$_SESSION['announcement_edited'] = true;
					
		if (!$result1) {
			//set announcement_edited to false for alert
			$_SESSION['announcement_edited'] = false;
			echo "Could not successfully run query {$update_announcement} from DB: " . mysql_error();
			exit;
		}
	
		unset($_POST);
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