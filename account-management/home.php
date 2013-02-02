<?php
	session_start();
	if(!isset($_SESSION['uname'])){
		header("Location: login-module.php");
	}
	
	echo "<a href = \"editacct-module.php\">Edit Account</a></br>";
	echo "<a href = \"signout-module.php\">Sign Out</a>";
	
?>
