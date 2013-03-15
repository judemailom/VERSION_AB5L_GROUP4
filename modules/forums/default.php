<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	//unset($_SESSION['forum_id']);
	
	if(isset($_POST['create_forum'])){
			$a = performQuery('INSERT INTO forum VALUES ("", "'.$_POST['forum_name'].'", "'.$_POST['forum_desc'].'", '.$USER[0]['user_id'].');');
			if($a){
				$_SESSION['success']=2;
				$_SESSION['mode'] = 'created';
			}
			else
				$_SESSION['success']=0;
			header('location: #');
	}
	if(isset($_POST['edit_forum'])){
		$_SESSION['forum_id'] = $_POST['forum_id'];
		header('location: ?page=edit_forum_members');
	}
	
	if(isset($_POST['delete_forum'])){
		$a = performQuery('CALL delete_forum('.$_POST['forum_id'].')');
		if($a){
				$_SESSION['success']=2;
				$_SESSION['mode'] = 'deleted';
			}
			else
				$_SESSION['success']=0;
			header('location: #');
	}
?>	
<!----------------------------------------MODAL FOR CREATING FORUM-------------------------------------------------->
<div id="add_forum" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="add_forum" aria-hidden="true">	
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4>Create New Forum</h4>
	</div>
	<div class="modal-body">
		<form action = "?page=forums" method="post" onsubmit="okClicked();">
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
<?php 
if(isset($_SESSION['success']) && $_SESSION['success']>=1){ ?>
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
<div class="row-fluid">
	<div class="span8 forum-content">
	</div>
	
</div>
