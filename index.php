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
			<div id="header">
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
								<tr><td>I learn. You learn. We learn. Chos!</td>
								</tr>
							</table>
						</div>
						<div class="span1" style="text-align: right;">
							<img src="img/dots.png" id="dots" />
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
					</div>
				</div>
			</div>
			<div <?php echo isset($_SESSION['user'])?'id="content"':'class="main"'; ?>>
				<?php	
			}
			if(isset($_SESSION['user'])){
		?>	
			<div class="navbar navbar-inverse">
				 <div class="navbar-inner">
					<a class="brand" href="#">Menu</a>
			        <div class="container">
			          <div class="nav-collapse">
			            <ul class="nav">
			              <li class="<?php echo $_GET['page']=='home'?'active':''; ?>">
			                <a href="?page=home">Home</a>
			              </li>
			              <li class="<?php echo $_GET['page']=='tests'?'active':''; ?>">
			                <a href="?page=tests">Tests</a>
			              </li>
			              <li class="<?php echo $_GET['page']=='view_classlist'?'active':''; ?>">
			                <a href="?page=view_classlist">Classlists</a>
			              </li>
			              <li class="<?php echo $_GET['page']=='forums'?'active':''; ?>">
			                <a href="?page=forums">Forums</a>
			              </li>
			            </ul>
						<form class="navbar-search pull-left" action="">
							<input type="text" class="search-query span2" placeholder="Search">
	                    </form>
						<ul class="nav pull-right">
							<li><a href="#">@<?php echo $_SESSION['user']; ?></a></li>
							<li class="divider-vertical"></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#demo">Account <b class="caret"></b></a>
								<div id="demo" class="collapse in"> 
									<ul class="dropdown-menu">
										<li>User Type</a></li>
										<li>School name</a></li>
										<li>Level or department</a></li>
										<li class="divider"></li>
										<li><a href="#">Edit account</a></li>
										<li><a href="#">Logout</a></li>
									</ul>
								</div>
							</li>
	                    </ul>
			          </div>
			        </div>
			    </div>
			</div>
		<?php	}
			if(isset($_SESSION['user'])){	?>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
			<?php } ?>
					<div >
						<div class="row-fluid">
							<?php if(isset($_SESSION['user'])){ ?>
								<div class="span1">
								</div>
							<?php }	?>
							<div class="<?php echo isset($_SESSION['user'])?'span10':'span12'; ?>" id="<?php echo isset($_SESSION['user'])?'content':'main'; ?>">
								<?php	include 'modules/'.((!isset($_GET['page']))?'index':$_GET['page']).'/default.php'; ?>
							</div>
							<?php if(isset($_SESSION['user'])){ ?>
								<div class="span1">
								</div>
							<?php }	?>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div class="navbar navbar-inverse navbar-fixed-bottom">
			<div class="navbar-inner">
				<div class="container">
					  <div class="nav-collapse">
						<ul class="nav">
							<li><a href="">About iLearn</a></li>
						</ul>
						<ul class="nav">
							<li><a href="">Location</a></li>
						</ul>
						<ul class="nav">
							<li><a href="">Developers</a></li>
						</ul>
						<ul class="nav">
							<li><a href="">Contact Us</a></li>
						</ul>
						<ul class="nav">
							<li><a href="">Link2</a></li>
						</ul>
						<ul class="nav">
							<li><a href="">Link3</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
   </body>
</html>