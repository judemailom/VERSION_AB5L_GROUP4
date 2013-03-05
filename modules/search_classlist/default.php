<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<div id="add_classlist">
	<div class="row-fluid">
		<div class="span4">
			<form id="add_classlist" method="post" action="">
				<table id="add_classlist">
				
					<tr><th colspan="2">Search Classlist</td></tr>
					<tr><td class="body" >Student Name: </td><td class="body"><input type="text" name="studname" class="search_classlist_text" required="required" /></td>
					<td class="body" colspan="2"><select id="select_classlist" name="classlist">
								<option>Select Classlist</option>
								<?php
									$classlists = performQuery('select classlist_name from classlist;');
									for($i=0;$i<sizeof($classlists);$i++){ ?>
										<option><?php echo $classlists[$i]['classlist_name']; ?></option>
								<?php	}
								?>
						</select></td>
						<td class="body"><input type="submit" class="delete_classlist" name = "clnameview_submit" value = "Search classlist" pattern = "[A-z ]{1,}" /></td></tr>
				<?php
					include "includes/connect.php";
					include "includes/use_db.php";
					include "includes/print_classlist.php";
					//include "includes/query.php";
					if(isset($_POST['clnameview_submit'])){
						$flagy = 0;
						$temp=$_POST['studname'];
						$query="SELECT user_id FROM user WHERE user_fname LIKE '%$temp%' and user_type='Student'";
						$result=mysql_query($query,$con);
						//$result=mysql_fetch_assoc($result);
						$query=performQuery("SELECT user_id FROM user WHERE user_fname LIKE '%$temp%' and user_type='Student'");
						
						if(mysql_num_rows($result)==0){
							echo "<tr><td>{$_POST['classlist']}</td></tr>";
							echo "<tr><td>No match results found haha</td></tr>";
						}else{
							//var_dump($query);
						for($i=0;$i<sizeof($query);$i++){
							
							$query2="SELECT classlist_user_id FROM classlist_members WHERE classlist_user_id='{$query[$i]['user_id']}' AND classlist_id=(SELECT classlist_id from classlist where classlist_name='{$_POST['classlist']}')";
							
							$result2=mysql_query($query2,$con);
							
							$query2=performQuery("SELECT classlist_user_id FROM classlist_members WHERE classlist_user_id='{$query[$i]['user_id']}' AND classlist_id=(SELECT classlist_id from classlist where classlist_name='{$_POST['classlist']}')");
							//var_dump($query2);
							if(mysql_num_rows($result2)==0 && $i==sizeof($query)-1 && !isset($array)){
								//var_dump(sizeof($query));
								echo "<tr><td>{$_POST['classlist']}</td></tr>";
								echo "<tr><td>No match results found hihi</td></tr>";
								//$array[]=null;
								//var_dump($array);
							}else if(mysql_num_rows($result2)==0 && isset($array)){
								//var_dump($query[$i]['user_id']);
								continue;
							}else{
								$array[]=$query2[0]['classlist_user_id'];
								//var_dump($array);
							}
						}
						if(isset($array)){
							for($j=0;$j<sizeof($array);$j++){
								$query3=performQuery("SELECT user_fname FROM user WHERE user_id='{$array[$j]}'");
								//var_dump($query3);
								$namearray[]=$query3[0]['user_fname'];
							}
							echo "<tr><th colspan=2>{$_POST['classlist']}</td></tr>";
							$counter=1;
							for($k=0;$k<sizeof($namearray);$k++){
								echo "<tr><td colspan=2>$counter. $namearray[$k]</td></tr>";
							}
						}
						}
					}
				?>
				
				</table>
			</form>
		</div>
	</div>
</div> 