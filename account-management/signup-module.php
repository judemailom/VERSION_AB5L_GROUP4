<?php
	session_start();
?>
<section id="signup">
	<form action = "signup-process.php" method = "post">
		<label for = "uname">Username(at least 6 char): </label><br/>
		<input type = "text" name = "uname"    required = "required" pattern = "[A-z0-9]{6,}"/> <br/><br/>

		<label for = "pass1">Password(at least 6 char): </label><br/>
		<input type = "password" name = "pass1"  pattern = "[A-z0-9]{6,}" required = "required"/> <br/><br/>

		<label for = "pass2">Re-type password: </label><br/>
		<input type = "password" name = "pass2"  pattern = "[A-z0-9]{6,}" required = "required"/> <br/><br/>

		<label for = "fname">First name: </label><br/>
		<input type = "text" name = "fname" required = "required" pattern = "[A-z ]{1,}"  /> <br/><br/>

		<label for = "lname">Last name: </label><br/>
		<input type = "text" name = "lname" required = "required" pattern = "[A-z ]{1,}" /> <br/><br/>

		<label for = "school">School: </label><br/>
		<input type = "text" name = "school" required = "required" /> <br/><br/>
		
		<input type = "radio"  name = "type" value="Student" required = "required" onclick = "enableTextBox('lvl','dpt')"/>
		<label for = "type">Student</label><br/><br/>

		<input type = "radio"  name = "type" value= "Teacher" required = "required" onclick = "enableTextBox('dpt','lvl')" />
		<label for = "type">Teacher</label><br/><br/>
		
		<label for = "level">Level: </label><br/>
		<input type = "text" id="lvl" name = "level" disabled="true" required = "false"/> <br/><br/>
		
		<label for = "dept">Department: </label><br/>
		<input type = "text" id="dpt" name = "dept" disabled="true" required = "false" /> <br/><br/>

		<input type = "submit" value = "Register"/>
	</form>
</section>
