<html>
	<body>
<?php
	session_start();
	require_once "connect_db/connect.php";
	require_once "connect_db/use_db.php";

	$query = "select * from user where user_uname = '{$_SESSION['uname']}'";	
	$result = mysql_query($query, $con);
	$sid =  mysql_fetch_assoc($result);
	
	//tokenize full name para madisplay ulit sa Firstname at Lastname
	$count=0;
	$tok = strtok($sid['user_fname'], " ");
	while($tok){
		$token[] = $tok;
		$tok = strtok(" ");
		$count++;
	}
	$firstname = "";
	for ($i=0; $i<$count-1; $i++)
		$firstname = $firstname." ".$token[$i];
	
	echo '<form action = "editacct-process.php" method = "post">
	<label for = "uname">Username: </label><br/>
	<input type = "text" name = "uname" value = "'.$sid['user_uname']. '" required = "required" pattern = "[A-z0-9]{6,}"/> <br/><br/>

	<label for = "pass1">Password: </label><br/>
	<input type = "password" name = "pass1"  pattern = "[A-z0-9]{6,}" value ="" required = "required" onchange = "form.pass2.pattern = this.value;"/> <br/><br/>

	<label for = "pass2">Re-type password: </label><br/>
	<input type = "password" name = "pass2"  value ="" pattern = "[A-z0-9]{6,}" required = "required"/> <br/><br/>

	<label for = "fname">First name: </label><br/>
	<input type = "text" name = "fname" value ="'.$firstname. '" required = "required" pattern = "[A-z ]{1,}"  /> <br/><br/>
	
	<label for = "lname">Last name: </label><br/>
	<input type = "text" name = "lname" value ="'.$token[$count-1]. '" required = "required" pattern = "[A-z ]{1,}" /> <br/><br/>
	
	<input type = "submit" value = "Save"/>
</form>';
	//try tokenizing fullname - echo yung buong log-in page
?>
	</body>
</html>