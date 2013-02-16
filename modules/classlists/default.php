
<div id="view_classlist">
	<div class="row-fluid">
		<div class="span4">
			<form id="view_classlist" method="post" action="">
				<table id="view_classlist">
					<tr><td class="body" colspan="2"><select id="select_classlist" name="classlist">
								<option>Select Classlist</option>
								<?php
									$classlists = performQuery('select classlist_name from classlist;');
									for($i=0;$i<sizeof($classlists);$i++){ ?>
										<option><?php echo $classlists[$i]['classlist_name']; ?></option>
								<?php	}
								?>
						</select></td><td class="body"><input type="submit" class="view_classlist" name = "clnameview_submit" value = "view classlist" pattern = "[A-z ]{1,}" /></td></tr>
						</form>
				<?php
					include "includes/connect.php";
					include "includes/use_db.php";
					include "includes/print_classlist.php";
					
					if(isset($_POST['delete'])){
						//$_SESSION['classlist'];
						//echo $_SESSION['classlist'];
						$query1 = "select memberid from classlist_member where id=(SELECT id from classlist where classlist_name='{$_SESSION['classlist']}')";
						$result1 = mysql_query($query1,$con);					
						while($row = mysql_fetch_assoc($result1)){
							$array[] = $row; 
						}
						
						for($j=0;$j<sizeof($array);$j=$j+1){
							//echo "HAHAHAHA";
							$temp="{$j}";
							if(isset($_POST['delete'][$temp])){
								//echo "HAHAHAHA";
								$query2 = "DELETE FROM classlist_member WHERE id=(SELECT id FROM classlist WHERE classlist_name='{$_SESSION['classlist']}') AND memberid='{$array[$j]['memberid']}'";
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