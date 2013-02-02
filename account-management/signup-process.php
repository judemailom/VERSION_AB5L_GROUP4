<?php
	session_start();
//	$_SESSION = $_POST;
	require_once "connect_db/connect.php";
	require_once "connect_db/use_db.php";
	
	$flagy=0;
	//query to check for duplicate table elements
	$query = "select * from user";	
	$result = mysql_query($query, $con);
	
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
		
		if($flagy!=1 || mysql_num_rows($result) == 0 ){ //if there is no duplicate or table is empty, insert
			$new_user = "insert into user (user_uname,user_password,user_fname,user_type) values(
						'{$uname}',
						'{$pass}',
						'{$fname}', 
						'{$_POST['type']}'
					)";
					$result1 = mysql_query($new_user, $con);
					
					if (!$result1) {
						echo "Could not successfully run query {$new_student} from DB: " . mysql_error();
						exit;
					}else{
						if('Student'===$_POST['type']){
							$query1 = "select * from user where user_uname ='{$uname}'";
							$result1 = mysql_query($query1, $con);
							$sid =  mysql_fetch_assoc($result1);
							$new_student = "insert into student values(
								'{$sid['user_id']}',
								'{$_POST['school']}',
								'{$_POST['level']}'
							)";
							mysql_query($new_student, $con);
						}
						else if('Teacher'===$_POST['type']){
							$query1 = "select * from user where user_uname ='{$uname}'";
							$result1 = mysql_query($query1, $con);
							$sid =  mysql_fetch_assoc($result1);
							$new_teacher = "insert into teacher values(
								'{$sid['user_id']}',
								'{$_POST['dept']}',
								'{$_POST['school']}'
							)";
							mysql_query($new_teacher, $con);
						}
						header("Location: login-module.php");
					}
		}
	
	

	require_once "connect_db/close.php";
?>