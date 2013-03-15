<?php
	include 'includes/query.php';
	session_start();
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
	}
	if(isset($_POST['edit_forum'])){
		$_SESSION['forum_id'] = $_POST['forum_id'];
		header('location: ?page=edit_forum_members');
	}
	if(isset($_POST['create_forum'])){
			$a = performQuery('INSERT INTO forum VALUES ("", "'.$_POST['forum_name'].'", "'.$_POST['forum_desc'].'", '.$USER[0]['user_id'].');');
			if($a){
				$_SESSION['success']=4;
				$_SESSION['mode'] = 'created';
			}
			else
				$_SESSION['success']=0;
			//var_dump($_SESSION);
			header('location: #');
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
						<?php 	if(isset($_SESSION['user']) && $_SESSION['user_type'] != "Administrator") {?>
							<div class ="span7 menu">
								<div class="menu-item <?php echo isset($_GET['page'])?$_GET['page']=='add_announcement'?'active':'':''; ?>">
									<a <?php $sub = $_SESSION['user_type']=='Teacher'?'add_announcement':'home'; echo isset($_GET['page'])&&$_GET['page']==$sub?'class="active"':''; ?> href="?page=<?php echo $_SESSION['user_type']=='Teacher'?'add_announcement':'home' ?>">Home</a>
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
						<?php }
						else if(isset($_SESSION['user']) && $_SESSION['user_type']== "Administrator"){ ?>
							<div class ="span7 menu">
								<div class="menu-item <?php echo isset($_GET['page'])?$_GET['page']=='add_announcement'?'active':'':''; ?>">
									<a <?php echo isset($_GET['page'])&&$_GET['page']=='home'?'class="active"':''; ?> href="?page=home">Home</a>
								</div>
								<div class="menu-item">
									<a <?php echo isset($_GET['page'])&&$_GET['page']=='manage_forums'?'class="active"':''; ?> href="?page=manage_forums">Manage Forums</a>
								</div>
								<div class="menu-item">
									 <a <?php echo isset($_GET['page'])&&$_GET['page']=='manage_accounts'?'class="active"':''; ?> href="?page=manage_accounts">Manage Accounts</a>
								</div>
							</div>
						<?php }	
						include 'modules/'.((!isset($_GET['page']))?'index':$_GET['page']).'/default.php'; ?>

					<!-------------------------------------------------FORUM NAVIGATOR-------------------------------------------------------------------->
						
						<?php if(isset($_SESSION['user'])){?>
							<div id="forums" class="span3">
								<div class="row-fluid">
									<form method="post" action="?page=forum_search">
										<div class="input-append">
											<div class="input-append center-aligned">
											  <input id="appendedInputButton" name="search_key" type="text" placeholder="Search forum...">
											  <button class="btn" type="submit" name="search">Go!</button>
											</div>
										</div>
									</form>
								</div>
								<?php 
								if(isset($_SESSION['success']) && $_SESSION['success']>=1 && $_SESSION['mode']=='created'){ ?>
									<div class="alert alert-success">
									  <button type="button" class="close" data-dismiss="alert">&times;</button>
									  <strong>Congratulations!</strong> Successfully <?php echo $_SESSION['mode']; ?> a forum.
									</div>
								<?php
								}
								else if(isset($_SESSION['success']) && $_SESSION['success']<0){ ?>
									<div class="alert alert-error">
									  <button type="button" class="close" data-dismiss="alert">&times;</button>
									  <strong>Sorry!</strong> Something went wrong. Please try again. 
									</div>
								<?php }
								if(isset($_SESSION['success'])){
									if(($_SESSION['success']==1 || $_SESSION['success']<0)){
										unset($_SESSION['success']);
										unset($_SESSION['mode']);
									}
									else
										$_SESSION['success']-=1;
								}
								?>
								<?php 
								//var_dump($_SESSION);
								if(isset($_SESSION['success']) && $_SESSION['success']>=1 && $_SESSION['mode']=='joined'){ ?>
									<div class="alert alert-success">
									  <button type="button" class="close" data-dismiss="alert">&times;</button>
									  <strong>Congratulations!</strong> Successfully joined a forum.
									</div>
								<?php
								}
								else if(isset($_SESSION['success']) && $_SESSION['success']<0){ ?>
									<div class="alert alert-error">
									  <button type="button" class="close" data-dismiss="alert">&times;</button>
									  <strong>Sorry!</strong> Something went wrong. Please try again. 
									</div>
								<?php }
								if(isset($_SESSION['success'])){
									if(($_SESSION['success']==1 || $_SESSION['success']<0)){
										unset($_SESSION['success']);
										unset($_SESSION['mode']);
									}
									else
										$_SESSION['success']-=1;
								} ?>
								<div class="row-fluid">
									<div class="span12">
										<div class="containerDiv">
											<table class="table table-striped center-aligned">
												<tr>
													<th>Your forums</th>
													<th colspan="3">Actions</th>
												</tr>
												<?php if($_SESSION['user_type']!='Student'){ ?>
													<tr id = "create">
														<td colspan="5" id="create"><a name="create" data-toggle="modal" id="create" href="#add_forum">&plus; Create new forum...</a></td>
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
							<!----------------------------------------MODAL FOR CREATING FORUM-------------------------------------------------->
							<div id="add_forum" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="add_forum" aria-hidden="true">	
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4>Create New Forum</h4>
								</div>
								<div class="modal-body">
									<form action = "" method="post" onsubmit="okClicked();">	
									<div class="input-prepend">
									  <span class="add-on"><i class="icon-tags"></i></span>
									  <input class="span10" name="forum_name" id="prependedInput" type="text" placeholder="Forum title..." required="required" />
									</div>
									<div class="input-prepend">
									   <span class="add-on"><i class="icon-list"></i></span>
									  <input class="span10" name="forum_desc" id="prependedInput" type="text" placeholder="Forum description..." required="required" />
									</div>
										You may edit the members after creation.
								</div>
								<div class="modal-footer">
										<input type="submit" value="Create forum" name="create_forum" />
									</form>
								</div>
							</div>
							<!-----------------------------------------END MODAL-------------------------------------------------->
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