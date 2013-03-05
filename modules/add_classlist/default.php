<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<div id="add_classlist">
	<div class="row-fluid">
		<div class="span4">
			<form id="add_classlist" method="post" action="">
				<table id="add_classlist">
				<?php
					$uname=$_SESSION['user'];
					include "includes/connect.php";
					include "includes/use_db.php";
					if(isset($_POST['clname_submit'])){
						$flagy = 0;
						$temp=$_POST['clname'];
						$query="SELECT * FROM classlist WHERE classlist_name='$temp'";
						$check=mysql_query($query, $con);
						while ($row = mysql_fetch_assoc($check)) {
							if($temp===$row['classlist_name']){
								$flagy = 1;
							include 'js/uname_taken.js';
							break;
							}
						}
						$rolecheckquery = "SELECT user_type FROM user where user_uname='$uname'";
						$result=mysql_query($rolecheckquery,$con);
						$result=mysql_fetch_assoc($result);
						if(!$flagy && $result['user_type'] == 'Teacher'){
							$insert = "INSERT INTO CLASSLIST (classlist_name,classlist_author_id) VALUES ('{$temp}',(SELECT user_id from user where user_uname='$uname'))";	
							$result = mysql_query($insert, $con);
							include 'js/add_classlist_success.js';
						}else if(!$flagy && $result['user_type'] == 'Student'){
							echo "<tr><td class=body colspan=2>";
							echo "Insufficient priveleges. Unable to access these feature." .mysql_error();
							echo "<td></tr>";
						}else{
							echo "<tr><td class=body colspan=2>";
							include 'js/classlist_name_exists.js';
							echo "<td></tr>";
						}
						
					}
				?>
					<tr><th colspan="2">Add classlist</td></tr>
					<tr><td class="body" >Classlist Name: </td><td class="body"><input type="text" name="clname" class="add_classlist_text" required="required" </td><td class="body"><input type="submit" class="add_classlist_text" name = "clname_submit" value = "Create classlist" pattern = "[A-z ]{1,}" /></td>
				</table>
			</form>
		</div>
	</div>
</div> 
<div id="add_classlist_success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="add_classlist_success" aria-hidden="true">	
	<div class="modal-header">
		<h3>Classlist successfully added!</h3>
	</div>
	<div class="modal-header">
		<a href="#" class="btn btn-primary" onclick="okClicked();">OK</a>
	</div>
</div>
<div id="classlist_name_exists" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="classlist_name_exists" aria-hidden="true">	
	<div class="modal-header">
		<h3>Classlist name already exists in database.</h3>
	</div>
	<div class="modal-body">
		Please use a different name.
	</div>
	<div class="modal-header">
		<a href="#" class="btn btn-primary" onclick="okClicked();">OK</a>
	</div>
</div>