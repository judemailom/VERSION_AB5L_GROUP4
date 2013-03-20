<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<div id="edit_classlist">
	<div class="row-fluid">
		<div class="span4">
			<form id="edit_classlist1" method="post" action="">
				<table id="edit_classlist" class="table table-striped">
					<tr><td class="body" colspan="2"><select id="edit_classlist" name="edit_classlist">
								<option>Add Student</option>
								<option>Delete Student</option>
						</select></td><td class="body"><input type="submit" class="edit_classlist" name = "edit_classlist_submit" value = "Edit classlist" pattern = "[A-z ]{1,}" /></td></tr>
				<?php
					include "includes/connect.php";
					include "includes/use_db.php";
					include 'includes/print_classlist.php';
					
					if(isset($_POST['add_student_button'])){
							
							$temp=$_POST['classlist'];
							
							$query= "select user_id from user where user_fname='{$_POST['add_student']}' and user_type='Student'";
							$result = mysql_query($query,$con);
							$row = mysql_fetch_assoc($result);
							$query3= performQuery("select classlist_id from classlist where classlist_name='$temp';");
							
							$query4= "select classlist_user_id from classlist_members where classlist_user_id =(select user_id from user where user_fname LIKE '%{$_POST['add_student']}%') and classlist_id={$query3[0]['classlist_id']}";
							$result2 = mysql_query($query4,$con);
							//var_dump($result);
							//$check=performQuery($query4);
							//var_dump($check);
							//var_dump($row);
							if(mysql_num_rows($result)==0){
								echo "Student is not in the database. It must exist so that it can be added to the classlist.". mysql_error();
							}else if(mysql_num_rows($result2) > 0){
								echo "Student already exists in the classlist.";
								printClasslist($_POST['classlist']);
							}else{
								$result2=mysql_query("INSERT INTO classlist_members VALUES ({$query3[0]['classlist_id']},{$row['user_id']})",$con);
								echo "<tr><td>Successfully added to the classlist</td></tr>";
								printClasslist($_POST['classlist']);
							}
							
					}
					echo "</form>";
					echo "<form id=edit_classlist2 method=post action=''>";
					if(isset($_POST['edit_classlist_submit'])){
						
						$flagy = 0;
						if($_POST['edit_classlist']=="Add Student"){
							echo "<tr><td class=body><input type=text class=add_student_text placeholder=Name name=add_student required=required pattern ='[A-z ]{1,}' /></td>";
							
							echo "<td class=body colspan=2><select id=select_classlist name=classlist>
								<option>Select Classlist</option>";
									$classlists = performQuery('select classlist_name from classlist;');
									for($i=0;$i<sizeof($classlists);$i++){ 
										echo "<option>{$classlists[$i]['classlist_name']}</option>";
										
									}
							echo "</select></td></tr>";
							echo "<tr><td class=body><input type=submit class=add_student name=add_student_button value='Add to classlist'/></td></tr>";
							
						}else if($_POST['edit_classlist']=="Delete Student"){
							$_SESSION['delete']=1;
							header("Location: ?page=view_classlist");
						}
						
					}
				?>
				
				</table>
			</form>
		</div>
	</div>
</div> 