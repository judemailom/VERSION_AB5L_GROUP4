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
			$a = performQuery('INSERT INTO forum VALUES ("", "'.$_POST['forum_name'].'", "'.$_POST['forum_desc'].'", '.$USER[0]['user_id'].', "'.$_POST['forum_key'].'");');
			if($a){
				$_SESSION['counter'] = 2;
				$_SESSION['status']='success';
				$_SESSION['mode']='created';
				$_SESSION['item']='forum';
			}
			else
				$_SESSION['status']='failed';
			//var_dump($_SESSION);
			header('location: #');
	}
	if(isset($_POST['enter_forum'])){
		$_SESSION['forum_id'] = $_POST['forum_id'];
		header('location: ?page=enter_forum');
	}
	if(isset($_POST['delete_forum'])){
		$a = performQuery('CALL delete_forum('.$_POST['forum_id'].')');
		if($a){
				$_SESSION['counter'] = 2;
				$_SESSION['status']='success';
				$_SESSION['mode']='deleted';
				$_SESSION['item']='forum';
			}
			else
				$_SESSION['status']='failed';
			//var_dump($_SESSION);
			//var_dump($_POST);
			if(isset($_GET['forum_id']) && $_GET['forum_id']==$_SESSION['forum_id'])
				header('location: ?page=forums');
			else
				header('location: #');
	}

	if(isset($_POST['leave_forum'])){
		$a = performQuery('DELETE FROM forum_members WHERE forum_id = '.$_SESSION['forum_id'].' AND forum_user_id = '.$_SESSION['user_id'].';');
		if($a){
			$_SESSION['counter'] = 2;
			$_SESSION['status']='success';
			$_SESSION['mode']='left';
			$_SESSION['item']='forum';
		}
		else
			$_SESSION['status']='failed';
		header('location: ?page=forums');
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
    <script src="js/forum_key.js"> </script>
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
								if(isset($_SESSION['counter'])){
									if( 0 <= $_SESSION['counter'] && $_SESSION['counter']<=2 ){
									//	var_dump($_SESSION);
										if(isset($_SESSION['status']) && $_SESSION['item'] == 'forum'){
											$status=$_SESSION["status"];
											$mode=$_SESSION["mode"];
											$item=$_SESSION["item"];
											include 'includes/alert.php';
										}
									}
									if($_SESSION['counter'] <= 2)
										$_SESSION['counter'] -=1;
									if($_SESSION['counter']<0){
										unset($_SESSION['counter']);
										unset($_SESSION['status']);
										unset($_SESSION['item']);
										unset($_SESSION['mode']);
									}
									}
								?>
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
																$author = performQuery('SELECT * FROM forum WHERE forum_id = '.$userForums[$i]['forum_id'].' AND forum_author_id='.$_SESSION['user_id'].';');
																if(!isset($myForums->num_rows)){
														?>
															<tr>
																<td><?php	echo $myForums[0]['forum_name'];?></td>
																<!--td><?php	echo $myForums[0]['forum_description'];?></td-->
																<td>
																	<form action="" method="post">
																		<input type="submit" title = "Enter this forum" class="action enter" value="" name="enter_forum" />
																		<input type="hidden" value="<?php echo $myForums[0]['forum_id']; ?>" name="forum_id" />
																	</form>
																</td>
																<?php
																	if(($_SESSION['user_type']=='Administrator' && !isset($author->num_rows)) || ($_SESSION['user_type']!='Student' && !isset($author->num_rows))){	?>
																<td>
																	<form action="" method="post">
																		<input type="submit" title = "Edit members of this forum" class="action edit" value="" name="edit_forum" />
																		<input type="hidden" value="<?php echo $myForums[0]['forum_id']; ?>" name="forum_id" />
																	</form>
																</td>
																<td>
																	<form action="" method="post" onSubmit="return confirm_delete();">
																		<input type="hidden" value="<?php echo $myForums[0]['forum_id']; ?>" name="forum_id" />
																		<input type="submit" title = "Delete this forum" class="action delete" value="" name="delete_forum" />
																	</form>
																</td>
																<?php }
																else{ ?>
																	<td>&minus;</td>
																	<td>&minus;</td>
																<?php } ?>
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
									<div class="row-fluid">All fields are required</div>
									<form action = "" method="post" onsubmit="return validate();" name="create_forum_form">	
									<div class="input-prepend">
									  <span class="add-on"><i class="icon-tags"></i></span>
									  <input class="span10" name="forum_name" id="prependedInput" type="text" placeholder="Forum title..." required="required" />
									</div>
									<div class="input-prepend">
									   <span class="add-on"><i class="icon-list"></i></span>
									  <input class="span10" name="forum_desc" id="prependedInput" type="text" placeholder="Forum description..." required="required" />
									</div>
									<div class="row-fluid">
										<div class="alert span10">
											Please enter forum key below. This will serve as a password for students upon joining. 
										</div>
									</div>
									<div class="input-prepend">
									   <span class="add-on"><i class="icon-check"></i></span>
									  <input class="span10" name="forum_key" id="prependedInput" type="text" placeholder="Forum key..." required="required" />
									</div>
									You may edit members after creating.
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
<script type="text/javascript">
function confirm_delete(){
	return confirm('Are you sure you want to delete this forum?');
};

</script>
