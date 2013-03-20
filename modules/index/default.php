<?php
	// -------------------------- LOG IN ----------------------------------
	if(isset($_SESSION['user']))
		header('location: ?page=home');
	if(isset($_SESSION['account_created'])){
			$_SESSION['success']=2;
		header('location: #');
		unset($_SESSION['account_created']);
	}
	if(isset($_POST['login_submit'])){
		require_once "includes/connect.php";
		require_once "includes/use_db.php";

		$query = "select * from user";	
		$result = mysql_query($query, $con);
		
		$uname = $_POST['uname'];
		$pass = md5($_POST['pass']);
		
		while($row = mysql_fetch_assoc($result)){
			if($uname===$row['user_uname'] && $pass===$row['user_password']){
				$_SESSION['user'] = htmlentities($uname);
				$a = performQuery('SELECT * FROM user WHERE user_uname="'.$uname.'";');
				$_SESSION['user_type'] = $a[0]['user_type'];	
				$_SESSION['user_id'] = $a[0]['user_id'];	
				$b = performQuery('SELECT '.$_SESSION['user_type'].'_school_name from '.$_SESSION['user_type'].' WHERE '.$_SESSION['user_type'].'_id = '.$_SESSION['user_id'].';');
				$_SESSION['user_school'] = $b[0][$_SESSION['user_type'].'_school_name'];	
				header("Location: ?page=home");
			}
		}
			$_SESSION['fail'] = 1;
		require_once "includes/close.php";
	}
	//----------------------------- END OF LOG IN ---------------------------
?>
<?php

	//-------------------------------SIGN UP ----------------------------------
	if(isset($_POST['signup_submit'])){	//user sign up
		include "includes/connect.php";
		include "includes/use_db.php";
		
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
					$_SESSION['flagy'] = 2;
					header('location: #signup');
					break;
			}
		}
		
		if(!isset($_SESSION['flagy']) || mysql_num_rows($result) == 0 ){ //if there is no duplicate or table is empty, insert
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
						header("Location: #");
					}
		}
		include "includes/close.php";
	}
	// ---------------------------------- END OF SIGN UP --------------------------

?>

<div class="span12">
	<div class="span12 top-home fixed-top" style="position: fixed">
		<div class="span3 title">
			<a href="#"><img class="logo" src="img/logo.png"/></a>
		</div>
		<div class="span4" style="padding-top: 35px;" >

			<?php if(isset($_SESSION['fail']) && $_SESSION['fail']==1){ ?>
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Sorry. </strong> Invalid username or password.
				</div>
			<?php	
				if($_SESSION['fail']>=0)
					$_SESSION['fail']-=1;
				else
					unset($_SESSION['fail']);
			} 
			if(isset($_SESSION['success']) && $_SESSION['success']>=1){ ?>
				<div class="alert alert-success">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  <strong>Congratulations!</strong> Successfully created your account!
				</div>
			<?php }
			if(isset($_SESSION['success'])){
				if(($_SESSION['success']==1 || $_SESSION['success']<0))
					unset($_SESSION['success']);
				else
					$_SESSION['success']-=1;
			} ?>

		</div>
		<div class="span5">	
			<form class="form-inline sign_in" name="sign_in" method="post" action="#">
				<input type="text" class="login_text" placeholder="Username" name = "uname" required = "required" pattern = "[A-z0-9]{6,}" />
				<input type="password" class="login_text" placeholder="Password" name = "pass" required = "required" pattern = "[A-z0-9]{6,}"/>
				<button type="submit" class="trans" name="login_submit"><i class="icon-circle-arrow-right"></i></button>

			</form>	
		</div>
	</div>
	<div id="home-img">
		<div class="span5">
		</div>
		<div class="span7 menu">
			<div class="menu-item">
				<a href="#">Home</a>
			</div>
			<div class="menu-item">
				<a href="#signup">Sign up</a>
			</div>
			<div class="menu-item">
				<a href="#about">About</a>
			</div>
			<div class="menu-item">
				<a href="#about_us">Contact Us</a>
			</div>
			<div class="menu-item">
				<a href="#about_us">Location</a>
			</div>
			<div class="menu-item">
				<a href="#about_us">Developers</a>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12 img-div">
				<div id="quote">
					<h4>Lorem ipsum dolor sit amet...,</h4>
				</div>
				<div id="quote2">
					<h4>consectetuer <label class="strong">adipiscing elit...</label></h4>
				</div>
				<img src="img/hd14.jpg" class="home-img-slide" />
			</div>
		</div>	
	</div>
	<div class="footer-details">
		<div id="signup">
			<h1>No account? Sign up now!</h1>
			<?php 
			if(isset($_SESSION['flagy'])){
					if($_SESSION['flagy']==2){ ?>
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Sorry. </strong> Username is already taken.
				</div>
			<?php
				}
				if($_SESSION['flagy']>=0)
					$_SESSION['flagy']-=1;
				else
					unset($_SESSION['flagy']);
			} ?>
			<form id="signup_form" method="post" action="">
				<div class="row-fluid">
					<div class="span3">
					</div>
					<div class="span3">
						<input type="text" class="login_text" placeholder="First Name" name = "fname" required = "required" pattern = "[A-z ]{1,}" />
						<br />
						<input type="text" class="login_text" placeholder="Last Name" name = "lname" required = "required" pattern = "[A-z ]{1,}" />
						<br />
						<input type="text" class="login_text" placeholder="Preferred Username" name = "uname" required = "required" pattern = "[A-z0-9]{6,}" />
						<br />
						<input type="password" class="login_text" placeholder="Password" name = "pass1"  pattern = "[A-z0-9]{6,}" required = "required" />
						<br />
						<input type="password" class="login_text" placeholder="Confirm Password" name = "pass2"  pattern = "[A-z0-9]{6,}" required = "required" />
						<br />
					</div>
					<div class="span3">
						<select id="select_schools" name="school">
							<option>Select School</option>
							<?php
								$schools = performQuery('select school_name from school;');
								for($i=0;$i<sizeof($schools);$i++){ ?>
									<option><?php echo $schools[$i]['school_name']; ?></option>
							<?php	}
							?>
						</select>
						<br />
						<a href="#about_us" style="font-size: 14px;">School not yet registered? Contact us.</a>
						<br />
						<input type="radio" id="student" value="Student" required = "required" onclick = "enableTextBox('lvl','dpt')" name = "type" /><label for="student">Student</label>
						<input type="radio" id="teacher" name = "type" value= "Teacher" required = "required" onclick = "enableTextBox('dpt','lvl')" /><label for="teacher">Teacher</label>
						<br />	
						<input type="text" class="login_text" placeholder="Level" id="lvl" name = "level" disabled="true" required = "false" />
						<br />
						<input type="text" class="login_text" placeholder="Department" id="dpt" name = "dept" disabled="true" required = "false"  />
						<br />
						<input type="submit" name="signup_submit" value="Create Account" class="button" />
					</div>
					<div class="span3">
					</div>
					<div class="span3">
					</div>
				</div>
			</form>
		</div>
		<div id="about">
			<h1>About iLearn : Why use iLearn?</h1>
			<div class="span4">
				<img src="img/world.png" class="why_ilearn_img" /><br />
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu 
				libero eget arcu consequat ullamcorper. Curabitur justo lectus, ullamcorper 
				ac tristique nec, facilisis id augue. Nullam luctus eni..
			</div>
			<div class="span4">
				<img src="img/chat.png" class="why_ilearn_img" /><br />
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu 
				libero eget arcu consequat ullamcorper. Curabitur justo lectus, ullamcorper 
				ac tristique nec, facilisis id augue. Nullam luctus eni..
			</div>
			<div class="span4">
				<img src="img/puzzle.png" class="why_ilearn_img" /><br />
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu 
				libero eget arcu consequat ullamcorper. Curabitur justo lectus, ullamcorper 
				ac tristique nec, facilisis id augue. Nullam luctus eni..
			</div>
		</div>
		<div id="about_us">
			<h1>About Us</h1>
			<div class="span4">
				<img src="img/email.png" class="why_ilearn_img" /><br />
				<label class="red">Contact us: <br /></label>
				Email: contact@ilearn.com<br />
				Mobile: (+639) XXX-XXX-XXX<br />
				Landline: (+63X) XXX XXXX
			</div>
			<div class="span4">
				<img src="img/car.png" class="why_ilearn_img" /><br />
				<label class="red">Location: <br /></label>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu 
				libero eget arcu consequat ullamcorper. Curabitur justo lectus, ullamcorper 
				ac tristique nec, facilisis id augue. Nullam luctus eni..
			</div>
			<div class="span4">
				<img src="img/dev.png" class="why_ilearn_img" /><br />
				<label class="red">Developers<br /></label>
				Aseneta, Julian Paul<br />
				Galos, Sefora<br />
				Mailom, Jude<br />
				Manas, Jean Nicolette<br />
				Marinay, Marjhel<br />
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