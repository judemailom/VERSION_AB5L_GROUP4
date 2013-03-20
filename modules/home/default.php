<!-- ALERTS -->
<?php
	if((isset($_SESSION['announcement_added'])) || (isset($_SESSION['announcement_deleted'])) || (isset($_SESSION['announcement_edited']))){
?>
	<div class="span8" style="padding-top: 5px; padding-left: 50px;" >
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong> 
				<?php
					if(isset($_SESSION['announcement_added']))
						echo "You have successfully added an announcement!";
					else if(isset($_SESSION['announcement_deleted']))
						echo "You have successfully deleted an announcement!";
					else if(isset($_SESSION['announcement_edited']))
						echo "You have successfully edited an announcement!";
				?>
			</strong>
		</div>
	</div>
<?php
	}
		unset($_SESSION['announcement_added']);
		unset($_SESSION['announcement_deleted']);
		unset($_SESSION['announcement_edited']);
?>
<!-- End of ALERTS PHP -->

<!-- POST ANNOUNCEMENT -->
<?php
	
	require_once "includes/connect.php";
	require_once "includes/use_db.php";
	//if post announcement button is clicked
	if(isset($_POST['post_announcement'])){
		require_once "includes/query.php";	

		//get user information
		$query = "select * from user where user_uname = '{$_SESSION['user']}'";	
		$result = mysql_query($query, $con);
		$sid =  performQuery($query);

		//save user information gathered via query in variables
		$announcement_title = $_POST['announcement_title'];
		$announcement_content = $_POST['announcement_content'];
		
		//insert announcement into database
		$new_announcement = "insert into announcement (announcement_author,author_id,announcement_date,announcement_title,announcement_content) 
						values(
							'{$sid[0]['user_fname']}',
							'{$sid[0]['user_id']}',
							NULL,
							'{$announcement_title}', 
							'{$announcement_content}'
						)";
		$result1 = mysql_query($new_announcement, $con);
		//set announcement_added to true for the alert
		$_SESSION['announcement_added'] = true;
					
		if (!$result1) {
			//set announcement_added to false for the alert
			$_SESSION['announcement_added'] = false;
			echo "Could not successfully run query {$new_announcement} from DB: " . mysql_error();
			exit;
		}
	
		unset($_POST);	
		//back to home page
		header("Location: ?page=home");	
		include "includes/close.php";
	}
?>
<!-- End of Post Announcement php -->

<!-- Same school query and isempty -->
<?php
	require_once "includes/query.php";
	require_once "includes/connect.php";
	require_once "includes/use_db.php";
	//get user information
	$query =  'select * from user where user_uname = "'.$_SESSION['user'].'";';
	$r = performQuery($query);
	$user_type = $r[0]['user_type'];
	$user_id = $r[0]['user_id'];
	$isEmpty = true;

	if($user_type == 'Administrator'){
		$announcements = performQuery('select * from announcement where author_id in (select admin_id from admin);');
		$announceNum = mysql_query('select COUNT(announcement_id) from announcement where author_id in(select admin_id from admin);');
	}
	else if($user_type == 'Teacher'){
		$user_school = performQuery("select * from teacher where teacher_id=".$user_id.";");

		//select all announcements from database where author has the same school as the user or author is admin
		$announcements = performQuery('select * from announcement where author_id in (select admin_id from admin) or author_id in (select teacher_id from teacher where teacher_school_name="'.$user_school[0]['teacher_school_name'].'");');
		//count number of announcements
		$announceNum = mysql_query('select COUNT(announcement_id) from announcement where author_id in(select admin_id from admin) or author_id in (select teacher_id from teacher where teacher_school_name="'.$user_school[0]['teacher_school_name'].'");');
	}
	else{
		$user_school = performQuery('select student_school_name from student where student_id='.$user_id.';');

		//get announcement information
		$announcements = performQuery("select * from announcement where author_id in (select admin_id from admin) or author_id in (select teacher_id from teacher where teacher_school_name='".$user_school[0]['student_school_name']."');");
		$query = "select COUNT(announcement_id) from announcement where author_id in (select admin_id from admin) or author_id in (select teacher_id from teacher where teacher_school_name='".$user_school[0]['student_school_name']."');";
	}	
		//if announcement is empty
 	while($row = mysql_fetch_array($announceNum)){
		if($row['COUNT(announcement_id)'] > 0){
			$isEmpty = false;			//announcement is not empty
		}
	}
?>
<!-- End of same school query and isempty -->


<!--Post Announcement Modal -->
<div id="announcementModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-header">
   	 	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
   	 		&times;
   	 	</button>
   		<h3 id="myModalLabel">
   			Create Announcement
   		</h3>
  	</div>
 	<div class="modal-body">
   		<form id="announcementModalForm" method="post" action="" class="form-horizontal">
			<div class="control-group">
				<label class="control-label" for="announcement_title">
					Announcement Title
				</label>
				<div class="controls">
					<input type="text" id="announcement_title" required="required" name="announcement_title" placeholder="Title">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="announcement_content">
					Body
				</label>
				<div class="controls">
					<textarea placeholder="Announcement..." required="required" resizable="false" rows="10" name="announcement_content" id="announcement_content">
					</textarea>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button class="btn" data-dismiss="modal" aria-hidden="true">
						Close
					</button>
    				<button type="submit" class="btn" name="post_announcement">
    					Post Announcement
    				</button>
				</div>
			</div>
		</form>
  	</div>
  	<div class="modal-footer">
    </div>
</div>
<!-- End of Post Announcement Modal -->

<!-- Announcement part -->
<div id='announcements' class="row-fluid span8">
	<h2> Announcements </h2>
	<div class="row-fluid">
		<?php
		if($user_type == 'Teacher' || $user_type == 'Administrator'){
		?>
			<div class="span10">
				<div class="span5">
					<a  href="#announcementModal"  role="button" class="createlink" data-toggle="modal">
						<i class="icon-plus-sign" id="createcolor"></i> Create Announcement
					</a>
				</div>
			</div>
		<?php
		}
		?>
			<div id='announcementinner' class="row-fluid span11">
				<div class="span12">
					<div class="row-fluid">
						<div class="span10">
							<div class="announcement">
								<!-- Carousel -->
								<div id="myCarousel" class="carousel slide">
 									<!-- Carousel items -->
 									<div class="carousel-inner">
 									<?php
 										if($isEmpty == false){
 											$size= sizeof($announcements);
 											for($i=$size-1;$i>=0;$i--){
												if($i == $size-1){
    												echo'<div class="active item">';
    											}
    											else{
													echo'<div class="item">';
    											}
    								?>		
    												<div class="announce">
    													<div class="header">
														<?php
															echo $announcements[$i]['announcement_title'];
														?>
														</div>
														<div class="announcement_details">
															posted
														<?php
															$query = "select user_fname from user where user_id=".$announcements[$i]['author_id'].";";	
															$fullname = performQuery($query);
															echo $announcements[$i]['announcement_date'];
															echo " by ";
															echo $fullname[0]['user_fname'];
														?>
														</div>
														<br /><br />
														<div id="divContent" class="content">
															<p  id="announce_content" >
															<?php
																echo $announcements[$i]['announcement_content'];
															?>
															</p>
														</div>
														<?php
														if($user_type == 'Teacher' || $user_type == 'Administrator'){
														?>
														<div class="edit">
															<form id="editAnnounceForm" action="?page=edit_announcement" method="post" class="lefty">
																<input type="hidden" id="announcement_id" name="announcement_id" <?php echo 'value="'.$announcements[$i]['announcement_id'].'"';?> />
																<input type="hidden" id="announcement_title" name="announcement_title" <?php echo 'value="'.$announcements[$i]['announcement_title'].'"';?> />
																<input type="hidden" id="announcement_content" name="announcement_content" <?php echo 'value="'.$announcements[$i]['announcement_content'].'"';?> />
																<?php
																	if($announcements[$i]['author_id'] == $user_id)
																		echo '<input type="submit" value="Edit" class="button edit"/>';
																?>
															</form>
															<form id="deleteAnnounceForm" action="?page=delete_announcement" method="post" class="lefty">
																<input type="hidden" id="announcement_id" name="announcement_id" <?php echo 'value="'.$announcements[$i]['announcement_id'].'"';?> />
																<input type="hidden" id="announcement_title" name="announcement_title" <?php echo 'value="'.$announcements[$i]['announcement_title'].'"';?> />
																<input type="hidden" id="announcement_content" name="announcement_content" <?php echo 'value="'.$announcements[$i]['announcement_content'].'"';?> />
																<?php
																	if($announcements[$i]['author_id'] == $user_id)
																		echo '<input type="submit" value="Delete" class="button edit"/>';
																?>
															</form>
														</div>
														<?php
														}
														?>
													</div>
												</div>
										<?php
											}
										?>
									<?php
										}
										else{
											echo '<div class="noannouncement">';
											echo "No Announcements Available";
											echo '</div>';
										}
									?> 
 				 									</div> <!-- end of active item/item -->
	  								<!-- Carousel nav -->
	  								<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
	  								<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
	  							</div>
	  						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<!-- End of announcement part -->

<script type='text/javascript'>
	function enableTextBox(getid,getid2){
		document.getElementById(getid).disabled = false;
		document.getElementById(getid).required = "required";
		document.getElementById(getid2).value = "";
		document.getElementById(getid2).disabled = true;
	}
</script>