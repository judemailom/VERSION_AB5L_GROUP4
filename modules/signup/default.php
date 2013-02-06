<?php
	if(isset($_POST['signup_submit'])){	//user sign up
		include "includes/connect.php";
		include "includes/use_db.php";
		
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
					$flagy = 1;
					include 'js/uname_taken.js';
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
						unset($_POST);	
						$_SESSION['account_created']=1;
						//for the modal pop up for "Account successfully registered"
						header("Location: ?page=login");
					}
		}
		include "includes/close.php";
	}
?>
<div id="uname_taken" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="uname_taken" aria-hidden="true">	
	<div class="modal-header">
		<h3>There is an error in creating your account.</h3>
	</div>
	<div class="modal-body">
		Your username is already taken.
	</div>
	<div class="modal-header">
		<a href="#" class="btn btn-primary" onclick="okClicked();">OK</a>
	</div>
</div>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="span4">
				<div id="signup">
					<form id="signup" method="post" action="">
						<table id="signup">
							<tr><th colspan="2">Sign up</td></tr>
							<tr><td class="body" colspan="2"><a href="?page=login">Already a member? Log in now!</a></td></tr>
							<tr><td class="body"><input type="text" class="signup_text" placeholder="First Name" name = "fname" required = "required" pattern = "[A-z ]{1,}" /></td><td class="body"><input type="text" class="signup_text" placeholder="Last Name" name = "lname" required = "required" pattern = "[A-z ]{1,}" /></td></tr>
							<tr><td class="body" colspan="2"><input type="text" class="signup_text" placeholder="Preferred Username" name = "uname" required = "required" pattern = "[A-z0-9]{6,}" /></td></tr>
							<tr><td class="body" colspan="2"><input type="password" class="signup_text" placeholder="Password" name = "pass1"  pattern = "[A-z0-9]{6,}" required = "required" /></td></tr>
							<tr><td class="body" colspan="2"><input type="password" class="signup_text" placeholder="Confirm Password" name = "pass2"  pattern = "[A-z0-9]{6,}" required = "required" /></td></tr>
							<tr><td class="body" colspan="2"><select id="select_schools" name="school">
								<option>Select School</option>
								<?php
									include 'includes/query.php';
									$schools = performQuery('select school_name from school;');
									for($i=0;$i<sizeof($schools);$i++){ ?>
										<option><?php echo $schools[$i]['school_name']; ?></option>
								<?php	}
								?>
							</select></td></tr>
							<tr><td class="body" colspan="2" colspan="2"><a href="" style="font-size: 14px;">School not yet registered? Contact us.</a></td></tr>
							<tr>
								<td class="body">
								<input type="radio" id="student" value="Student" required = "required" onclick = "enableTextBox('lvl','dpt')" name = "type" /><label for="student">Student</label>
								</td>
								<td class="body">
								<input type="radio" id="teacher" name = "type" value= "Teacher" required = "required" onclick = "enableTextBox('dpt','lvl')" /><label for="teacher">Teacher</label>
								</td>
							</tr>
							<tr><td class="body" colspan="2"><input type="text" class="signup_text" placeholder="Level" id="lvl" name = "level" disabled="true" required = "false" /></td></tr>
							<tr><td class="body" colspan="2"><input type="text" class="signup_text" placeholder="Department" id="dpt" name = "dept" disabled="true" required = "false"  /></td></tr>
							<tr><td class="body" colspan="2"><input type="submit" name="signup_submit" value="Create Account" class="button" /></td></tr>
						</table>
					</form>
				</div>
			</div>
			<div class="span8">
				Carousel here. Si Sefora na bahala. :D
			</div>
		</div>
	</div>
</div>
<script type='text/javascript'>
	function enableTextBox(getid,getid2){
		document.getElementById(getid).disabled = false;
		document.getElementById(getid).required = "required";
		document.getElementById(getid2).value = "";
		document.getElementById(getid2).disabled = true;
	}
</script>