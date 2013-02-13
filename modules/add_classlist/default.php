
<div id="add_classlist">
	<div class="row-fluid">
		<div class="span4">
			<form id="add_classlist" method="post" action="">
				<table id="add_classlist">
				<?php
					include "includes/connect.php";
					include "includes/use_db.php";
					if(isset($_POST['clname_submit'])){
						$flagy = 0;
						$temp=$_POST['clname'];
						$query="SELECT * FROM classlist WHERE clname='$temp'";
						$check=mysql_query($query, $con);
						while ($row = mysql_fetch_assoc($check)) {
							if($temp===$row['clname']){
								$flagy = 1;
							include 'js/uname_taken.js';
							break;
						}
		}
						if(!$flagy){
							$insert = "INSERT INTO CLASSLIST (clname) VALUES ('{$temp}')";	
							$result = mysql_query($insert, $con);
							echo "Classlist successfully added";
						}else{
							echo "<tr><td class=body colspan=2>";
							echo "Classlist name already exists." .mysql_error();
							echo "<td></tr>";
						}
						
					}
				?>
					<tr><th colspan="2">Add classlist</td></tr>
					<tr><td class="body" >Classlist Name: </td><td class="body"><input type="text" name="clname" class="add_classlist_text" required="required" </td><td class="body"><input type="submit" class="add_classlist_text" name = "clname_submit" value = "add classlist" pattern = "[A-z ]{1,}" /></td>
				</table>
			</form>
		</div>
	</div>
</div> 