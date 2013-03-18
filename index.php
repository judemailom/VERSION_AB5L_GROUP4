<?php
	include 'includes/query.php';
	session_start();
	//session_destroy();
	
	if(isset($_SESSION['user'])){
		$USER = performQuery( "SELECT * FROM user WHERE user_uname='".$_SESSION['user']."';");
	//	echo 'SELECT * FROM forum_members WHERE forum_user_id='.$USER[0]['user_id'].';';
	
		if($USER[0]['user_type'] == 'Student')
			$userForums = performQuery('SELECT * FROM forum_members WHERE forum_user_id='.$USER[0]['user_id'].';');
		else{
			//echo 'SELECT * FROM forum WHERE forum_author_id = '.$USER[0]['user_id'].' OR forum_id IN (SELECT forum_id FROM forum_members WHERE forum_user_id = '.$USER[0]['user_id'].');';
			$userForums = performQuery('SELECT * FROM forum WHERE forum_author_id = '.$USER[0]['user_id'].' OR forum_id IN (SELECT forum_id FROM forum_members WHERE forum_user_id = '.$USER[0]['user_id'].');');
			//var_dump($userForums);
		}
		if(isset($_GET['func']) && $_GET['func']=='create_forum'){
			include 'js/add_forum.js';
			unset($_GET['func']);
		}	
	}
	if(isset($_POST['enter_forum'])){
		$_SESSION['forum_id'] = $_POST['forum_id'];
		header('location: ?page=enter_forum');
		}
	
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
				<div id="header">
					<!--div class="row-fluid"-->
						<div class="span3">
							<a href="<?php echo isset($_SESSION['user'])?'?page=home':'index.php'; ?> ">
								<img src="img/logo.png" id="logo" />
							</a>
						</div>
						<div class="span6">
						</div>
						<div class="span3 nav pull-right account">
							<div class="menu-item menu">
								Welcome <a class="username" href="#" data-toggle="dropdown">@<?php echo $_SESSION['user']; ?></a> ! 
								<ul class="dropdown-menu" role="menu" aria-labelledby="account">
				                        <li role="presentation"><a class="dropdown-element" role="menuitem" tabindex="-1" href="">@<?php echo $_SESSION['user']; ?></a></li>
				                        <li role="presentation"><a class="dropdown-element" role="menuitem" tabindex="-1" href=""><?php echo $_SESSION['user_type']; ?></a></li>
				                        <li role="presentation"><a class="dropdown-element" role="menuitem" tabindex="-1" href="?page=edit_account">Edit account</a></li>
				                        <li role="presentation" class="divider"></li>
				                        <li role="presentation"><a class="dropdown-element" role="menuitem" tabindex="-1" href="?page=logout">Logout</a></li>
				                      </ul>
							</div>
				                      
						</div>
				</div>
				<?php } ?>
				<div class="row-fluid <?php echo isset($_SESSION['user'])?'below-header':'';?>">
					<div class="span12" id="content">
						<?php if(isset($_SESSION['user'])){?>
							<div class ="span7 menu">
								<div class="menu-item <?php echo isset($_GET['page'])?$_GET['page']=='home'?'active':'':''; ?>">
									<a <?php $sub = $_SESSION['user_type']=='Teacher'?'home':'home'; echo isset($_GET['page'])&&$_GET['page']==$sub?'class="active"':''; ?> href="?page=<?php echo $_SESSION['user_type']=='Teacher'?'home':'home' ?>">Home</a>
								</div>
								<div class="menu-item">
									<a <?php echo isset($_GET['page'])&&$_GET['page']=='tests'?'class="active"':''; ?> href="?page=tests">Tests</a>
								</div>
								<div class="menu-item">
									 <a <?php echo isset($_GET['page'])&&$_GET['page']=='view_classlist'?'class="active"':''; ?> href="?page=view_classlist">Classlists</a>
								</div>
								<div class="menu-item">
									<a <?php echo isset($_GET['page'])&&$_GET['page']=='forums'?'class="active"':''; ?>href="?page=forums">Forums</a>
								</div>
							</div>
							<div class="span5 right-aligned account">
								
							</div>
						<?php }	
						include 'modules/'.((!isset($_GET['page']))?'index':$_GET['page']).'/default.php'; ?>

<!-------------------------------------------------FORUM NAVIGATOR-------------------------------------------------------------------->
						<?php if(isset($_SESSION['user'])){?>
							<div id="forums" class="span3">
								<div class="row-fluid">
									<div class="span12">
										<div class="containerDiv">
											<table class="table table-striped center-aligned">
												<tr>
													<th>Your forums</th>
													<!--th>Description</th-->
													<th colspan="3">Actions</th>
												</tr>
												<?php if($_SESSION['user_type']=='Teacher'){ ?>
													<tr id = "create">
														<td colspan="5" id="create"><a name="create" id="create" href="?page=forums&&func=create_forum">&plus; Create new forum...</a></td>
													</tr>
												<?php } ?>
												<?php
													if(!isset($userForums->num_rows)){	
														for($i=0; $i<sizeof($userForums);$i++){ 
																$myForums = performQuery('SELECT * FROM forum WHERE forum_id = '.$userForums[$i]['forum_id'].';');
																if(!isset($myForums->num_rows)){
														?>
															<tr>
																<td><?php	echo $myForums[0]['forum_name'];?></td>
																<!--td><?php	echo $myForums[0]['forum_description'];?></td-->
																<td>
																	<form action="" method="post">
																		<input type="submit" class="action enter" value="" name="enter_forum" />
																		<input type="hidden" value="<?php echo $myForums[0]['forum_id']; ?>" name="forum_id" />
																	</form>
																</td>
																<?php
																	if($_SESSION['user_type']=='Teacher'){	?>
																<td>
																	<form action="" method="post">
																		<input type="submit" class="action edit" value="" name="edit_forum" />
																		<input type="hidden" value="<?php echo $myForums[0]['forum_id']; ?>" name="forum_id" />
																	</form>
																</td>
																<td>
																	<form action="" method="post" onSubmit="return confirm_delete();">
																		<input type="hidden" value="<?php echo $myForums[0]['forum_id']; ?>" name="forum_id" />
																		<input type="submit" class="action delete" value="" name="delete_forum" />
																	</form>
																</td>
																<?php } ?>
																</td>
															</tr>
												<?php		}
														}
													}
													else{
														if($USER[0]['user_type'] == 'Student'){ ?>
															<tr><td colspan="3">You are not a member of any forum. You can search for a forum in the search bar and ask to join.</td></tr>
													<?php	}
														else{	?>
															<tr><td colspan="3">You do not own a forum. You can create a forum by clicking Create Forum above.</td></tr>
													<?php	}
													}	?>
											</table>
										</div>	
									</div>	
								</div>
							</div>
<!--------------------------------------------------------------END OF FORUM NAVIGATOR ------------------------------------------------------>
						<?php } ?>
					</div>
				</div>
			</div>
   </body>
</html>
<script>
function confirm_delete(){
	return confirm('Are you sure you want to delete this forum?');
}
</script>