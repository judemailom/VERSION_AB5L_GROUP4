<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<div id="view_classlist">
	<div class="row-fluid">
		<div class="row-fluid">
			<div class="span2">
				<?php if($_SESSION['user_type'] == 'Teacher'){	?>
					<form action="?page=add_classlist" method="post">
						<input type="submit" value="Create classlist" name="create_classlist">
					</form>
			</div>
			<div class="span2">
			<form action="?page=edit_classlist" method="post">
						<input type="submit" value="Edit a classlist" name="create_classlist">
					</form>
				<?php } ?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span4">
				<form id="view_classlist" method="post" action="">
					<table id="view_classlist">
						<tr><td class="body" colspan="2"><select id="select_classlist" name="classlist">
									<?php $classlists = performQuery('select classlist_name from classlist;'); ?>
									<option><?php echo isset($classlists->num_rows)?'Not a member of any classlist':'Select Classlist'; ?></option>
									<?php
										//include 'includes/query.php';
										if(!isset($classlists->num_rows)){
										for($i=0;$i<sizeof($classlists);$i++){ ?>
											<option><?php echo $classlists[$i]['classlist_name']; ?></option>
									<?php	}
										}
									?>
							</select></td><td class="body"><input type="submit" class="view_classlist" name = "clnameview_submit" value = "View classlist" /></td></tr>
							</form>
					<?php
						include "includes/connect.php";
						include "includes/use_db.php";
						include "includes/print_classlist.php";
						
						if(isset($_POST['delete'])){
							//$_SESSION['classlist'];
							//echo $_SESSION['classlist'];
							$query1 = "select classlist_user_id from classlist_members where classlist_id=(SELECT classlist_id from classlist where classlist_name='{$_SESSION['classlist']}')";
							$result1 = mysql_query($query1,$con);					
							while($row = mysql_fetch_assoc($result1)){
								$array[] = $row; 
							}
							
							for($j=0;$j<sizeof($array);$j=$j+1){
								//echo "HAHAHAHA";
								$temp="{$j}";
								if(isset($_POST['delete'][$temp])){
									//echo "HAHAHAHA";
									$query2 = "DELETE FROM classlist_members WHERE classlist_id=(SELECT classlist_id FROM classlist WHERE classlist_name='{$_SESSION['classlist']}') AND classlist_user_id='{$array[$j]['classlist_user_id']}'";
									$result2 = mysql_query($query2,$con);
									if($result2) unset($_SESSION['delete']);
									printClasslist($_SESSION['classlist']);
								}
								//unset($_SESSION['classlist']);
							}
								
						}
				
							
						//}
						
						if(isset($_POST['clnameview_submit'])){
							printClasslist($_POST['classlist']);
						}
							echo "</table></form>";
						
					?>
					
					</table>
				</form>
			</div>
		</div>
	</div>
</div> 