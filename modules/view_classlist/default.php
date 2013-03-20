<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<div id="view_classlist" class="span9">
	<h3> View Classlist </h3>
	<div class="span9">
		<?php if(isset($_SESSION['edit_classlist']) && $_SESSION['user_type']=="Teacher"){?>
		<div class="span9">
			<a  href="#addmemberModal"  role="button" class="createlink" data-toggle="modal">
				<i class="icon-plus-sign" id="createcolor"></i> Add Member to Classlist
			</a>
		</div>
		<?php } ?>
	</div>
	<div class="row-fluid">
		<div class="row-fluid">
			<div class="span12">
				<form id="view_classlist" method="post" action="" onsubmit="return verify();">
					<table id="view_classlist">
						<!--<tr><td class="body" colspan="2">Classlists</td></tr>-->
						
				<!--</form>-->
					<?php
						
						include "includes/print_classlist.php";
						include "includes/connect.php";
						include "includes/use_db.php";
						
						$uname=$_SESSION['user'];
						if(isset($_SESSION['view_classlist']) && !isset($_SESSION['edit_classlist'])){
							//unset($_SESSION['edit_classlist']);
								//$query=performQuery("Select Select classlist_author_id from classlist where classlist_name='{$_SESSION['classlist_name']}'");
								//$query2=performQuery("");
								printClasslist($_SESSION['classlist_name']);
						}else if(!isset($_POST['delete']) && !isset($_POST['add_student_button']) && isset($_SESSION['edit_classlist'])){			
								printClasslist($_SESSION['classlist_name']);
						}else if(isset($_POST['delete'])){
							
							//$_SESSION['classlist'];
							//echo $_SESSION['classlist'];
							
							$query1 = "select classlist_user_id from classlist_members where classlist_id=(SELECT classlist_id from classlist where classlist_name='{$_SESSION['classlist']}')";
							$result1 = mysql_query($query1,$con);					
							while($row = mysql_fetch_assoc($result1)){
								$array[] = $row; 
							}
							
							for($j=0;$j<sizeof($array);$j=$j+1){
								
								$temp="{$j}";
								var_dump($_POST['delete'][$temp]);
								if(isset($_POST['delete'][$temp])){
									
									$query2 = "DELETE FROM classlist_members WHERE classlist_id=(SELECT classlist_id FROM classlist WHERE classlist_name='{$_SESSION['classlist']}') AND classlist_user_id='{$array[$j]['classlist_user_id']}'";
									$result2 = mysql_query($query2,$con);
									if($result2) {
									?>
								<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">×</button>
								You have successfully deleted a member in this classlist!
								</div>
									<?php
									}
									printClasslist($_SESSION['classlist']);
																	
								}
								//unset($_SESSION['classlist']);
							}
								
											
							
						
					?>
					</form>
					</table>
					<?php
					
					}else if(isset($_POST['add_student_button'])){
							
							$temp=$_SESSION['classlist_name'];
							$temp2=mysql_escape_string($_POST['add_student']);
							$query= "select user_id from user where user_fname='{$temp2}' and user_type='Student'";
							$result = mysql_query($query,$con);
							$row = mysql_fetch_assoc($result);
							$query3= performQuery("select classlist_id from classlist where classlist_name='$temp';");
							
							$query4= "select classlist_user_id from classlist_members where classlist_user_id =(select user_id from user where user_fname LIKE '%{$temp2}%') and classlist_id={$query3[0]['classlist_id']}";
							$result2 = mysql_query($query4,$con);
							?>
							<?php
							if(mysql_num_rows($result)==0){
							?>
							<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							
								You are trying to add a teacher in the classlist or the account does not exist. Please try again.
							</div>
							<?php printClasslist($temp);
							}else if(mysql_num_rows($result2) > 0){ ?>
							<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
								Student already exists in the classlist.
							</div>
							<?php
								printClasslist($temp);			
							
							}else{?>
							<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							You have successfully added a member in this classlist!
							<?php
								$result2=mysql_query("INSERT INTO classlist_members VALUES ({$query3[0]['classlist_id']},{$row['user_id']})",$con);
								printClasslist($temp);
							}?>
							</div>
							<?php
							unset($_POST['add_student_button']);
					}
					?>
					</table>
				</form>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span12">
				
					<form action="?page=classlists" method="post">
						<input type="submit" value="Back to Classlists Main" name="create_classlist" class="button" style="float:right;">
					</form>
			</div>
				
			
		</div>
	</div>
</div> 


 <!--Add Member Classlist Modal -->
<div id="addmemberModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-header">
   	 	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
   	 		&times;
   	 	</button>
   		<h3 id="myModalLabel">
   			Add Member to Classlist
   		</h3>
  	</div>
 	<div class="modal-body">
   		<form id="announcementModalForm" method="post" action="" class="form-horizontal">
   			<div class="control-group">
   				<label class="control-label" for="classlist_title">
   					Classlist Name:
   				</label>
   				<div class="controls">
   					<?php echo $_SESSION['classlist_name']; ?>
   				</div>
   			</div>
			<div class="control-group">
				<label class="control-label" for="student_title">
					Student Name:
				</label>
				<div class="controls">
					<input type="text" id="announcement_title" required="required" name="add_student" placeholder="Student Name">
				</div>
			</div>
			<div class="modal-footer">
				<div class="controls">
					<button class="btn" data-dismiss="modal" aria-hidden="true">
						Close
					</button>
    				<button type="submit" class="btn" name="add_student_button">
    					Add Member to Classlist
    				</button>
				</div>
			</div>
		</form>
  	</div>
</div>
<!-- End of Add Member Classlist Modal -->
<script type="text/javascript">
	function verify(){
		return confirm("Are you sure you want to delete this student from the classlist?");	
	}
 </script>