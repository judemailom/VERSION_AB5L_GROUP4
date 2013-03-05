<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	require_once "includes/connect.php";
	require_once "includes/use_db.php";
	
	if(isset($_POST['edit_account_submit'])){
		$flagy=0;
		//query to check for duplicate table elements
		$temp=$_SESSION['user'];
		$query = "select * from user where user_uname =  '$temp'";	
		$result = mysql_query($query, $con);
		$row = mysql_fetch_assoc($result);
		
		$userid = $row['user_id'];
		//save username
		$uname = $_POST['uname'];
		
		//concatenate fullname & save password as md5
		$fname = $_POST['fname'].' '.$_POST['lname'];
		$pass = md5($_POST['pass1']); 
		
			//if the table is already populated look for a possible duplicate table element
			while ($row = mysql_fetch_assoc($result)) {
				if($uname===$row['user_uname']){
						echo "<html> <body> <section id = \"signup\"></section></body></html>";//echo signup-module
						echo "User credentials already exist. Try again.<br/><br/>";
						echo "<a href = \"signup-module.php\">Sign Up</a>";
						$flagy = 1;
						break;
				}
			}
			if($flagy!=1){ //if there is no duplicate or table is empty, insert
				$update_user = "update user set user_uname ='{$uname}', 
							user_password = '$pass',
							user_fname = '{$fname}'
							where user_id = '{$userid}'";
						$result1 = mysql_query($update_user, $con);
						
						if (!$result1) {
							echo "Could not successfully run query {$update_student} from DB: " . mysql_error();
							exit;
						}else{
							//header("Location: login-module.php");
						}
			$_SESSION['user'] = $uname;
			}
	}
	$query = "select * from user where user_uname = '{$_SESSION['user']}'";	
	$result = mysql_query($query, $con);
	$sid =  performQuery($query);//mysql_fetch_assoc($result);
	
	//tokenize full name para madisplay ulit sa Firstname at Lastname
	$count=0;
	$tok = strtok($sid[0]['user_fname'], " ");
	while($tok){
		$token[] = $tok;
		$tok = strtok(" ");
		$count++;
	}
	$firstname = "";
	for ($i=0; $i<$count-1; $i++)
		$firstname = $firstname." ".$token[$i];
	require_once "includes/close.php";
	
?>
<div id="edit_account">
	<div class="row-fluid">
		<div class="span4">
			<form id="edit_account" method="post" action="">
				<table id="edit_account">
					<tr><th colspan="2">Edit account</td></tr>
					<tr><td class="body"><input type="text" class="edit_account_text" placeholder="<?php echo $firstname; ?>" name = "fname" required = "required" pattern = "[A-z ]{1,}" /></td><td class="body"><input type="text" class="edit_account_text" placeholder="<?php echo $token[$count-1]; ?>" name = "lname" required = "required" pattern = "[A-z ]{1,}" /></td></tr>
					<tr><td class="body" colspan="2"><input type="text" class="edit_account_text" placeholder="<?php echo $sid[0]['user_uname']; ?>" name = "uname" required = "required" pattern = "[A-z0-9]{6,}" /></td></tr>
					<tr><td class="body" colspan="2"><input type="password" class="edit_account_text" placeholder="Password" name = "pass1"  pattern = "[A-z0-9]{6,}" required = "required" /></td></tr>
					<tr><td class="body" colspan="2"><input type="password" class="edit_account_text" placeholder="Confirm Password" name = "pass2"  pattern = "[A-z0-9]{6,}" required = "required" /></td></tr>
					<tr><td class="body" colspan="2"><input type="text" class="edit_account_text" placeholder="Level" id="lvl" name = "level" disabled="true" required = "false" /></td></tr>
					<tr><td class="body" colspan="2"><input type="text" class="edit_account_text" placeholder="Department" id="dpt" name = "dept" disabled="true" required = "false"  /></td></tr>
					<tr><td class="body" colspan="2"><input type="submit" name="edit_account_submit" value="Save Changes" class="button" /></td></tr>
				</table>
			</form>
		</div>
	</div>
</div> 