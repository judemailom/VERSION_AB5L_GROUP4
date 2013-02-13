
<div id="delete_classlist">
	<div class="row-fluid">
		<div class="span4">
			<form id="delete_classlist" method="post" action="">
				<table id="delete_classlist">
					<tr><th>Delete Classlist<td></tr>
					<tr><td class="body" colspan="2"><select id="select_classlist" name="classlist">
								<option>Select Classlist</option>
								<?php
									include 'includes/query.php';
									$classlists = performQuery('select clname from classlist;');
									for($i=0;$i<sizeof($classlists);$i++){ ?>
										<option><?php echo $classlists[$i]['clname']; ?></option>
								<?php	}
								?>
						</select></td><td class="body"><input type="submit" class="delete_classlist" name = "clnameview_submit" value = "Delete classlist" pattern = "[A-z ]{1,}" /></td></tr>
						</form>
				<?php
					include "includes/connect.php";
					include "includes/use_db.php";
					include "includes/print_classlist.php";
					
					if(isset($_POST['clnameview_submit'])){
						$query = "DELETE FROM CLASSLIST WHERE clname='{$_POST['classlist']}'";
						$result = mysql_query($query);
						if($result) echo "Classlist successfully deleted.";
						header("Location: ?page=delete_classlist");
					}
					
				?>
				
				</table>
			</form>
		</div>
	</div>
</div> 