<?php
	include 'includes/query.php';
	session_start();
//	session_destroy();

	/*NAVIGATIONS*/
	if(isset($_POST['signup']))
		header('location: ?page=signup');
	if(isset($_POST['login']))
		header('location: ?page=login');
?>
	
<!DOCTYPE html>
<html>
  <head>
    <title>iLearn</title>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
	<script src="js/jquery.min.js"></script>
    <link href="bootstrap/css/bootstrap.responsive.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="css/text" href="<?php echo 'modules/'.((!isset($_GET['page']))?'index':$_GET['page']).'/default.css';?>"/>
    <link href="css/default.css" rel="stylesheet">
	
  </head>
   <body>    

		<?php 
			if(isset($_GET['page'])){
		?>	
			<div class="row-fluid">
			</div>
			<div class="row-fluid">
				<div class="span12">
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<div class="span2">
						<a href="<?php echo isset($_SESSION['user'])?'?page=home':'index.php'; ?> ">
							<img src="img/logo_mini.png" id="logo_header" />
						</a>
					</div>
					<div class="span9">
						<table id="desc">
							<tr><td>description description description description description description</td>
							</tr>
						</table>
					</div>
					<div class="span1" style="text-align: right;">
						<img src="img/dots.png" id="dots" />
					</div>
				</div>
			</div>
		<?php	
			}
			if(isset($_SESSION['user'])){
		?>	
			<div id="menu">
				<div class="row-fluid">
					<div class="span12">
						<div class="span2">
							<a href="?page=home">Home</a>
						</div>
						<div class="span2">
							<a href="?page=tests">Tests</a>
						</div>
						<div class="span2">
							<a href="?page=classlists">Classlists</a>
						</div>
						<div class="span2">
							<a href="?page=forums">Forums</a>
						</div>
						<div class="span4">
							<div class="input-append">
								<input type="text" id="search" placeholder="Search.." class="span6" />
								<button class="btn" type="button">Search</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php	}
			if(isset($_SESSION['user'])){
		?>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="span2">
						<div id="sidebar">
							<?php echo $_SESSION['user']; ?><br/>
							<?php 
								$type = performQuery('SELECT user_type FROM user WHERE user_uname = "'.$_SESSION['user'].'";');
								echo $type[0]['user_type'];
							?><br />
							<?php
								$school = performQuery('SELECT '.$type[0]['user_type'].'_school_name FROM '.$type[0]['user_type'].' WHERE '.$type[0]['user_type'].'_id = (SELECT user_id FROM user WHERE user_uname = "'.$_SESSION['user'].'");');
								echo $school[0]["".$type[0]['user_type']."_school_name"];
							?><br />
						</div>
						<div class="row-fluid">
							<div class="span12">
								<div class="user_actions">
									<i class="icon-pencil icon-white"></i>&nbsp;&nbsp;<a href="?page=edit_account">Edit account</a>
								</div>
								<div class="user_actions">
									<i class="icon-minus-sign icon-white"></i>&nbsp;&nbsp;<a href="?page=logout">Log out</a>
								</div>
							</div>
						</div>
					</div>
			<?php } ?>
					<div class="row-fluid">
						<div class="<?php echo isset($_SESSION['user'])?'span10':'span12'; ?>" >
							<?php
								include 'modules/'.((!isset($_GET['page']))?'index':$_GET['page']).'/default.php'; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="navbar navbar-fixed-bottom">
			<table style="margin: auto;">
				<tr>
					<td><a href="">About iLearn</a></td>
					<td><a href="">Location</a></td>
					<td><a href="">Developers</a></td>
					<td><a href="">Contact Us</a></td>
					<td><a href="">Link2</a></td>
					<td><a href="">Link3</a></td>
				</tr>
			</table>
		</div>
   </body>
</html>