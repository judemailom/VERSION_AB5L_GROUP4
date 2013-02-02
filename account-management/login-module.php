<?php
	session_start();
?>

<section id = "login">
	<form action = "login-process.php" method = "post">
		<label for = "username">Username:</label><br/>
		<input type = "text" name = "uname" required = "required" pattern = "[A-z0-9]{6,}"/><br/><br/>
		
		<label for = "password">Password:</label><br/>
		<input type = "password" name = "pass" required = "required" pattern = "[A-z0-9]{6,}"/><br/><br/>
		
		<input type = "submit" value = "Log In" /> 
		<a href = "signup-module.php">Create Account</a>
	</form>
</section>
