<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<div id="delete_user">
	<div class="row-fluid">
		<div class="span4">
			<form id="delete_user" method="post" action="">
				<table id="delete_user">
					<tr><th>Delete user<td></tr>
					<tr><td class="body" colspan="2"><select id="select_user" name="user">
								<option>Select user</option>
								<?php
									$users = performQuery('select user_fname from user;');
									for($i=0;$i<sizeof($users);$i++){ ?>
										<option><?php echo $users[$i]['user_fname']; ?></option>
								<?php	}
								?>
						</select></td><td class="body"><input type="submit" class="delete_user" name = "clnameview_submit" value = "Delete user" pattern = "[A-z ]{1,}" /></td></tr>
						</form>
				<?php
					include "includes/connect.php";
					include "includes/use_db.php";
					include "includes/print_user.php";
					
					if(isset($_POST['clnameview_submit'])){
						$query = "DELETE FROM user WHERE user_fname='{$_POST['user']}'";
						$result = mysql_query($query);
						if($result) echo "User successfully deleted.";
						header("Location: ?page=delete_user");
					}
					
				?>
				
				</table>
			</form>
		</div>
	</div>
</div> 