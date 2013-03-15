<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<div class="well">
	<div class="row-fluid">
		<div class="span9">
			<form id="add_user" method="post" action="">
				<table id="add_user">
				
					<tr><th colspan="2">Search user</td></tr>
					<tr><td class="body" >User Name: </td><td class="body"><input type="text" name="studname" class="search_user_text" /></td>
					<td class="body"><input type="submit" class="delete_user" name = "clnameview_submit" value = "Search user" pattern = "[A-z ]{1,}" /></td></tr>
			</form>
				<?php
					include "includes/connect.php";
					include "includes/use_db.php";
					
					if(isset($_POST['clnameview_submit'])){
						$flagy = 0;
						$temp=$_POST['studname'];
						
						//query for user full name
						$query=performQuery("SELECT * FROM user WHERE user_fname LIKE '%$temp%' ");
						
						echo "<table class='table table-striped'> <tr><th>User name</th><th>User type</th><th>Action</th></tr>";
						for($i=0;$i<sizeof($query);$i++){?>
							<form id="delete_user" method="post" action="">
						<?php	$query=performQuery("SELECT * FROM user WHERE user_fname LIKE '%$temp%' ");
							echo "<tr><td>{$query[$i]['user_fname']}</td>";
							echo "<td>{$query[$i]['user_type']}</td>";
							echo "<td><input type=submit class=delete_user name=delete_student value=Delete>
							<input type=hidden name=userid value={$query[$i]['user_id']}> </td></tr>";
						 ?>
							</form>
						<?php }
						echo "</table>";
						
						 if(sizeof($query)==0)
							 echo "<tr><td>No results found</td></tr>";
						 
					}
					
					if(isset($_POST['delete_student'])){
						$test = $_POST['userid'];
						$query2 = "DELETE FROM user WHERE user_id='$test'";
						$success = mysql_query($query2,$con);
						if($success) echo "prompt na nadelete na yay";
						else echo "di nadelete error";
					}
				?>
				
				</table>
		</div>
	</div>
</div> 