<?php
	session_start();
	$_SESSION = $_POST;
	require_once "connect_db/connect.php";
	require_once "connect_db/use_db.php";

	$query = "select * from user";	
	$result = mysql_query($query, $con);
	
	$uname = $_SESSION['uname'];
	$pass = md5($_SESSION['pass']);
	
	while($row = mysql_fetch_assoc($result)){
		if($uname===$row['user_uname'] && $pass===$row['user_password']){
			$_POST['uname'] = htmlentities($uname);
			header("Location: home.php");
			exit;
		}
	}
	
		echo "Invalid username and password. Try again.<br/><br/>";
		echo "<a href = \"login-module.php\">Log In</a>";
	
	require_once "connect_db/close.php";
?>