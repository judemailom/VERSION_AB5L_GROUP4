<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
		
	$temp="/local_ilearn_with_ui_new/index.php?page=classlists";
	if($_SERVER['REQUEST_URI']==$temp){
		unset($_SESSION['view_classlist']);
		unset($_SESSION['edit_classlist']);
	}
	
	if(isset($_POST['view_classlist'])){
		$_SESSION['classlist_name'] = $_POST['classlist_name'];
		$_SESSION['view_classlist'] = 1;
		header('location: ?page=view_classlist');
	}
?>

<!-- Delete Classlist Query and Alert -->
<?php 
	if(isset($_POST['delete_classlist'])){
		$query=performQuery("DELETE FROM CLASSLIST WHERE classlist_name='{$_POST['classlist_name']}'");
			if($query) {
				$_SESSION['classlist_deleted'] = true;
			}

			if(isset($_SESSION['classlist_deleted'])){
?>
			<div class="span8" style="padding-top: 5px;" >
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
						You have successfully deleted the classlist!
				</div>
			</div>
<?php		
				unset($_SESSION['classlist_deleted']);
			}
	}
?>
<!-- End of Delete Classlist Query and Alert -->

<!-- Edit Classlist Alert -->
<?php 
	if(isset($_POST['edit_classlist'])){
		$query=performQuery("SELECT classlist_author_id FROM CLASSLIST WHERE classlist_name='{$_POST['classlist_name']}'");
		$query2=performQuery("SELECT user_uname from user where user_id={$query[0]['classlist_author_id']}");
								
		if($query2[0]['user_uname']!=$_SESSION['user']) {
?>
			<div class="span8" style="padding-top: 5px;" >
			<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>
					You are not the author of this classlist, thus you cannot edit the classlist!
			</div>
			</div>
<?php 	}
		else{
			$_SESSION['classlist_name'] = $_POST['classlist_name'];
			$_SESSION['edit_classlist']=1;
			header('location: ?page=view_classlist');
		}
	}
?>
<!-- End of Edit Classlist Alert -->

<!-- Add Classlist Query and Alert -->
<?php
	if($_SESSION['user_type']=="Teacher"){
		include "includes/connect.php";
		include "includes/use_db.php";
		$uname=$_SESSION['user'];

		if(isset($_POST['clname_submit'])){
			$flagy = 0;
			$temp=mysql_escape_string($_POST['clname']);
			$query="SELECT * FROM classlist WHERE classlist_name='$temp'";
			$check=mysql_query($query, $con);
			
			while ($row = mysql_fetch_assoc($check)) {
				if($temp===$row['classlist_name']){
					$flagy = 1;
?>
					<div class="span8" style="padding-top: 5px;" >
						<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
								Classlist already exists. Please create a different class name.
						</div>
					</div>
<?php
					break;
				}
			}
			
			if(!$flagy && $_SESSION['user_type'] == 'Teacher'){
				$insert = "INSERT INTO CLASSLIST (classlist_name,classlist_author_id) VALUES ('{$temp}',(SELECT user_id from user where user_uname='$uname'))";	
				$result = mysql_query($insert, $con);
?>
				<div class="span8" style="padding-top: 5px;" >
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						You have successfully added a classlist!
					</div>
				</div>
<?php
			}

			else if(!$flagy && $result['user_type'] == 'Student'){
				echo "Insufficient priveleges. Unable to access these feature." .mysql_error();
			}
		}
	}
?>
<!-- End of Add Classlist Query and Alert -->

<div id="view_classlist">
	<div class="row-fluid">
		<div class="span9">
			<div class="containerDiv">
				<br/>
				<form method="post" action="">
					<table class="table-hover">
				<?php
					include "includes/connect.php";
					include "includes/use_db.php";
					include "includes/print_classlist.php";

					if(isset($_POST['clnameview_submit'])){
						$flagy = 0;
						$temp=mysql_escape_string($_POST['studname']);
						$query="SELECT user_id FROM user WHERE user_fname LIKE '%$temp%' and user_type='Student'";
						$result=mysql_query($query,$con);
						//$result=mysql_fetch_assoc($result);
						$query=performQuery("SELECT user_id FROM user WHERE user_fname LIKE '%$temp%' and user_type='Student'");
						//var_dump(mysql_fetch_assoc($result));
						if(mysql_num_rows($result)==0){
				?>
							<div class="span12" style="padding-top: 5px; padding-left: 30px;" >
								<div class="alert alert-error">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong> 
									<?php
										echo "No match results found in "; echo $_POST['classlist'];
									?>
									</strong>
								</div>
							</div>
				<?php
						}
						else{
							for($i=0;$i<sizeof($query);$i++){
								$query2="SELECT classlist_user_id FROM classlist_members WHERE classlist_user_id='{$query[$i]['user_id']}' AND classlist_id=(SELECT classlist_id from classlist where classlist_name='{$_POST['classlist']}')";
								$result2=mysql_query($query2,$con);
								
								$query2=performQuery("SELECT classlist_user_id FROM classlist_members WHERE classlist_user_id='{$query[$i]['user_id']}' AND classlist_id=(SELECT classlist_id from classlist where classlist_name='{$_POST['classlist']}')");
								if( $i==sizeof($query)-1 && mysql_num_rows($result2)==0 && !isset($array)){
				?>
									<div class="span12" style="padding-top: 5px; padding-left: 30px;" >
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">&times;</button>
											<strong> 
				<?php
												echo "No match results found in "; echo $_POST['classlist'];
				?>
											</strong>
										</div>
									</div>
				<?php
								}else if(mysql_num_rows($result2)==0 && isset($array)){
									continue;
								}else{
									
									if(mysql_num_rows($result2)==0) continue;
									else $array[]=$query2[0]['classlist_user_id'];
								}
							}

							if(isset($array)){
				?>
								<form action="" method="POST" onsubmit="return;">
									<input title="Close Results" type="submit"  name="close" class="close span8" value="&times;"/>
										<table class="table table-striped searchtable span4">
				<?php
											for($j=0;$j<sizeof($array);$j++){
												$query3=performQuery("SELECT user_fname FROM user WHERE user_id='{$array[$j]}'");
												$namearray[]=$query3[0]['user_fname'];
											}
											echo "<tr><th colspan=2>{$_POST['classlist']}</td></tr>";
											$counter=1;
											for($k=0;$k<sizeof($namearray);$k++){
												echo "<tr><td colspan=2>$counter. $namearray[$k]</td></tr>";
												$counter++;
											}
				?> 
										</table>
								</form>
				<?php
							}
						}
					}
				?>
					</table>
			</form>
			<br/><br/>
			
			<div id="classtable" class="span12">
				<h3> Your Classlists </h3>
					<div class="span5">
		<?php 
						if($_SESSION['user_type']=='Teacher'){
		?>
							<div class="span5">
								<a  href="#classlistModal"  role="button" class="createlink" data-toggle="modal">
									<i class="icon-plus-sign" id="createcolor"></i> Add Classlist
								</a>
							</div>
		<?php 			}
		?>
					</div>
					<div class="span6" style="float:right">
						<form method="post" action="">
							<table class="table-hover">
								<div class="input-append">
										<div class="input-append center-aligned ht">
												<input style="height: 75%;" type="text" placeholder="Student Name" name="studname" class="ht search_classlist_text yeah" required="required" />
												<select id="select_classlist" class="yeah ht" name="classlist">
													<option>Select Classlist</option>
												<?php
														if($_SESSION['user_type']=="Teacher") 
														$classlists = performQuery("select * from classlist where classlist_author_id=(SELECT user_id from user where user_uname='{$_SESSION['user']}');");
														else if ($_SESSION['user_type']=="Student") $classlists = performQuery("select * from classlist where classlist_author_id IN (Select teacher_id from teacher where teacher_school_name='{$_SESSION['user_school']}');");
														
														if(!isset($classlists->num_rows)){
														for($i=0;$i<sizeof($classlists);$i++){
												?>
															<option>
												<?php
																echo $classlists[$i]['classlist_name'];
												?>			</option>
												<?php	
														}
														}
												?>
												</select>
												<input type="submit" class="ht search_classlist button" name ="clnameview_submit" value = "Search classlist" pattern = "[A-z ]{1,}" />
										</div>
								</div>
							</table>
						</form>
					</div>
					<br/> <br/>
					<div class="span9">
					<table id="view_classlist" class="table table-striped">
						<tr>
							<th>Classlists</th>
							<!-- <th> Number of Students</th> -->
							<th colspan="5">Actions</th>
						</tr>
				<!--		<tr>
					<?php
						//$query = "select COUNT(classlist_user_id) from classlist_members where classlist_id = select classlist_id from classlist where classlist_name ='".$classlists[0]['classlist_name']."');";
						//$memberNum = mysql_query($query);
						//echo $memberNum;
					?>
						</tr>
				-->
					<?php
						
						//}else{
							if($_SESSION['user_type']=="Student"){
								$classlists = performQuery("select * from classlist where classlist_author_id IN (Select teacher_id from teacher where teacher_school_name='{$_SESSION['user_school']}');");
								echo "<td>You are not a member any classlists yet</td>";
								//var_dump($classlists);
							}else if($_SESSION['user_type']=="Teacher"){
								$classlists = performQuery("select * from classlist where classlist_author_id=(SELECT user_id from user where user_uname='{$_SESSION['user']}');");
								$query= performQuery("select COUNT(classlist_name) from classlist where classlist_author_id=(SELECT user_id from user where user_uname='{$_SESSION['user']}');");
								if($query[0]['COUNT(classlist_name)']==0) {
								$_SESSION['created_classlist_count']=0;
								echo "<td>You haven't created any classlists yet</td>";
								}
							}
						//var_dump($classlists);
						if(!isset($classlists->num_rows)){
						for($i=0;$i<sizeof($classlists);$i++){
						
					?>
						<tr>
							<form action='' method='post'>
								<td><?php echo $classlists[$i]['classlist_name'];?></td>
								<td><input type=hidden value="<?php echo $classlists[$i]['classlist_name'];?>" name=classlist_name /></td>
								<td>
									<?php
										//if($_SESSION['user_type']=='Student'){
									?>
											  <td><input type="submit" title = "View Classlist" class="action enter" value="" name="view_classlist" /></td>
									<?php	
										//}
										if($_SESSION['user_type']=='Teacher'){
											$query=performQuery("SELECT classlist_author_id FROM CLASSLIST WHERE classlist_name='{$classlists[$i]['classlist_name']}'");
											//var_dump($query[0]['classlist_author_id']);
											$query2=performQuery("SELECT user_id FROM USER WHERE user_uname='{$_SESSION['user']}'");
											//var_dump($query2[0]['user_id']);
											if($query[0]['classlist_author_id']==$query2[0]['user_id']){
									?>
											<td><input type="submit" title = "Edit Classlist" class="action edit" value="" name="edit_classlist" /></td>
									<?php
											}else echo "<td></td>";
										
										}
										
									?>
								</td>
							</form>
					<?php
						if($_SESSION['user_type']=='Teacher'){
					?>
							<form action='' method='post' onsubmit="return verify();">
								<td><input type=submit title="Delete Classlist" name=delete_classlist class="action delete" value=""/></td>
								<td><input type=hidden value="<?php echo $classlists[$i]['classlist_name'];?>" name=classlist_name /></td>
							</form>
					<?php
						}
					?>
						</tr>
					<?php
						}}
					?>	
				</table>
				 </div>
			</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function verify(){
		return confirm("Are you sure you want to delete this classlist?");	
	}
 </script>

 <!--Add Classlist Modal -->
<div id="classlistModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-header">
   	 	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
   	 		&times;
   	 	</button>
   		<h3 id="myModalLabel">
   			Create Classlist
   		</h3>
  	</div>
 	<div class="modal-body">
   		<form id="announcementModalForm" method="post" action="" class="form-horizontal">
			<div class="control-group">
				<label class="control-label" for="announcement_title">
					Classlist Name:
				</label>
				<div class="controls">
					<input type="text" id="announcement_title" required="required" name="clname" placeholder="Classlist Name">
				</div>
			</div>
			<div class="modal-footer">
				<div class="controls">
					<button class="btn" data-dismiss="modal" aria-hidden="true">
						Close
					</button>
    				<button type="submit" class="btn" name="clname_submit">
    					Create Classlist
    				</button>
				</div>
			</div>
		</form>
  	</div>
</div>
<!-- End of Add Classlist Modal -->

<!-- script for required fields -->
<script type='text/javascript'>
	function enableTextBox(getid,getid2){
		document.getElementById(getid).disabled = false;
		document.getElementById(getid).required = "required";
		document.getElementById(getid2).value = "";
		document.getElementById(getid2).disabled = true;
	}
</script>
<!-- script for required fields -->