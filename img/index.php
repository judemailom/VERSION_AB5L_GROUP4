<?php
	//foreach(glob('includes/*') as $file)
	//	include $file;
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
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap.responsive.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<!--CSS-->
    <link href="css/default.css" rel="stylesheet">
	<link rel="stylesheet" type="css/text" href="<?php echo 'modules/'.((!isset($_GET['page']))?'index':$_GET['page']).'/default.css';?>"/>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
	<script src="js/modal.js"></script>
	<script src="http://static.scripting.com/github/bootstrap2/js/jquery.js"></script>
	<script src="http://static.scripting.com/github/bootstrap2/js/bootstrap-transition.js"></script>
	<script src="http://static.scripting.com/github/bootstrap2/js/bootstrap-modal.js"></script>

	
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
							<input type="text" id="search" placeholder="Search.." />
							<i class="icon-search icon-white"></i>
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
							USERNAME<br/>
							TYPE<br />
							SCHOOL<br />
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