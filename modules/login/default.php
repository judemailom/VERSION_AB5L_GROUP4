<<<<<<< HEAD
<?php
	if(isset($_SESSION['user']))
		header('location: ?page=home');
	if(isset($_SESSION['account_created'])){
		include 'js/account_created.js';
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
				header("Location: ?page=home");
			}
		}
			$_SESSION['fail'] = 1;
		require_once "includes/close.php";
	}
?>
<div id="account_created" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="account_created" aria-hidden="true">
	<div class="modal-header">
		<h3>You have successfully registered to iLearn!</h3>
	</div>
	<div class="modal-footer">
		You can use your account to chu chu chu about about about about about about about about
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" onclick="okClicked();">Log in to iLearn</a>
	</div>
</div>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="span4">
				<div id="login">
					<div id="row-fluid">
						<form id="login" method="post" action="#">
							<table id="login">
								<tr><th>Login</td></tr>
								<?php if(isset($_SESSION['fail']) && $_SESSION['fail']==1){ 
								?>
								<tr><td>
								<div class="alert alert-error">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Sorry. </strong> Invalid username or password.
								</div></td>
								</tr>
								<?php	
									if($_SESSION['fail']>=0)
										$_SESSION['fail']-=1;
									else
										unset($_SESSION['fail']);
								}
								?>
								<tr><td><input type="text" class="login_text" placeholder="Username" name = "uname" required = "required" pattern = "[A-z0-9]{6,}" /></td></tr>
								<tr><td><input type="password" class="login_text" placeholder="Password" name = "pass" required = "required" pattern = "[A-z0-9]{6,}"/></td></tr>
								<tr><td><input type="submit" name="login_submit" value="Login" class="button" /></td></tr>
								<tr><td><a href="">Forgot password? Contact us</a></td></tr>
								<tr><td><a href="?page=signup">No iLearn account? Sign up now!</a></td></tr>
							</table>
						</form>
					</div>
				</div>
			</div>
			<div class="span8">
				Carousel here. Si Sefora na bahala. :D
			</div>
		</div>
	</div>
</div>