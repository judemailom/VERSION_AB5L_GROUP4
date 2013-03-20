<?php
	if(!isset($_SESSION['user'])){
		header('location: ?page=login');
	}
	if((isset($_SESSION['acctdeleted']))){
?>
	<div class="span8" style="padding-top: 5px; padding-left: 50px;" >
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong> 
				<?php
					if(($_SESSION['acctdeleted']==true)){
						echo "Account successfully deleted!";
					}
				?>
			</strong>
		</div>
	</div>
<?php
	unset($_SESSION['acctdeleted']);
	}
?>
<div class="row-fluid">
	<div class="span9">.
		<div class="well">
			<div class="row-fluid">
				<div class="span9">
					<form id="add_user" method="post" action="">
						<table>
						
							<tr><th colspan="2">Search user</td></tr>
							<tr><td class="body" >User Name: </td><td class="body"><input type="text" name="studname" class="search_user_text" /></td>
							<td class="body"><input type="submit" class="delete_user" name = "clnameview_submit" value = "Search user" pattern = "[A-z ]{1,}" /></td></tr>
						</table>
					</form>
						<?php
							include "includes/connect.php";
							include "includes/use_db.php";
							
							if(isset($_POST['clnameview_submit'])){
								$flagy = 0;
								$temp=$_POST['studname'];
								$temp2 = $_SESSION['user_id'];
								
								//query for user full name
								$query=performQuery("SELECT * FROM user WHERE user_fname LIKE '%$temp%' AND user_id != $temp2; ");
								
							?>	
							<table class='table table-striped'> 
								<tr>
									<th>User name</th>
									<th>User type</th>
									<th>Action</th>
								</tr>
							<?php	
								for($i=0;$i<sizeof($query);$i++){?>
								<?php	
									$query=performQuery("SELECT * FROM user WHERE user_fname LIKE '%$temp%' AND user_id != $temp2; ");
								 	if(!isset($query->num_rows)){
								 ?>
										<tr>
											<form id="delete_user" method="post" action="" onsubmit="return verify()" >
												<td><?php echo $query[$i]['user_fname'].' @'.$query[$i]['user_uname']; ?></td>
												<td><?php echo $query[$i]['user_type']; ?></td>
												<td>
													<input type="submit" class="delete_user" name="delete_student" value="Delete" />
													<input type="hidden" name="userid" value=<?php echo $query[$i]['user_id']; ?> />
												</td>
											</form>
										</tr>
								<?php	
									}
									else{
								?>
										<tr>
											<td colspan='3'>No results found</td>
										</tr>
								<?php	} ?>
								<?php } ?>
									
							</table>
					<?php			 
							}
							if(isset($_POST['delete_student'])){
								$test = $_POST['userid'];
								$query2 = "DELETE FROM user WHERE user_id='$test'";
								$success = mysql_query($query2,$con);
								if($success){
									$_SESSION['acctdeleted']= true;
								}
								else{
									$_SESSION['acctdeleted']= false;
								}
								header('Location: ?page=manage_accounts');
								include "includes/close.php";
							}
						?>
				</div>
			</div>
		</div> 
	</div>
</div>

<script type="text/javascript">
	function verify(){
		return confirm("Are you sure you want to delete?");
	}			
</script>				