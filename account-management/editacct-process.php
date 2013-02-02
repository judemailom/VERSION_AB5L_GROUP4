<?php
	session_start();
	$_SESSION = $_POST;
	require_once "connect_db/connect.php";
	require_once "connect_db/use_db.php";
	
	$flagy=0;
	//query to check for duplicate table elements
	$query = "select * from user where user_uname =  '{$_SESSION['uname']}'";	
	$result = mysql_query($query, $con);
	$row = mysql_fetch_assoc($result);
	
	$userid = $row['user_id'];
	//save username
	$uname = $_SESSION['uname'];
	
	//concatenate fullname & save password as md5
	$fname = $_SESSION['fname'].' '.$_SESSION['lname'];
	$pass = md5($_SESSION['pass1']); //pag nakamd5 na siya madodoble
	
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
						user_password = '{$pass}',
						user_fname = '{$fname}', 
						user_type = '{$_SESSION['type']}'
						where user_id = '{$userid}'";
					$result1 = mysql_query($update_user, $con);
					
					if (!$result1) {
						echo "Could not successfully run query {$update_student} from DB: " . mysql_error();
						exit;
					}else{
						header("Location: login-module.php");
					}
		}
	
	

	require_once "connect_db/close.php";
?>