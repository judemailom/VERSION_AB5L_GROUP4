<!-- POST ANNOUNCEMENT -->
<?php
	
	require_once "includes/connect.php";
	require_once "includes/use_db.php";

	//show if adding is successful
	if(isset($_SESSION['announcement_added'])){
		require_once 'js/announcement_added.js';
		unset($_SESSION['announcement_added']);
	}
	//show if deleting is successful
	else if(isset($_SESSION['announcement_deleted'])){
		require_once 'js/announcement_deleted.js';
		unset($_SESSION['announcement_deleted']);
	}
	//show if editing is successful
	else if(isset($_SESSION['announcement_edited'])){
		require_once 'js/announcement_edited.js';
		unset($_SESSION['announcement_edited']);
	}

	if(isset($_POST['post_announcement'])){
		//unset($_SESSION['announcement_added']);
		require_once "includes/query.php";	

		//get user information
		$query = "select * from user where user_uname = '{$_SESSION['user']}'";	
		$result = mysql_query($query, $con);
		$sid =  performQuery($query);//mysql_fetch_assoc($result);

		//save
		$announcement_title = $_POST['announcement_title'];
		$announcement_content = $_POST['announcement_content'];
		
		$new_announcement = "insert into announcement 
						values(
							'',
							'{$sid[0]['user_id']}',
							'{$announcement_title}', 
							'{$announcement_content}'
						)";
		$result1 = mysql_query($new_announcement, $con);
					
		if (!$result1) {
			echo "Could not successfully run query {$new_announcement} from DB: " . mysql_error();
			exit;
		}
	
		unset($_POST);
		$_SESSION['announcement_added'] = true;
		header("Location: ?page=add_announcement");	
		include "includes/close.php";
	}
?>
<!-- End of Post Announcement php -->

<?php

	$query =  'select * from user where user_uname = "'.$_SESSION['user'].'";';
	$r = performQuery($query);
	$user_type = $r[0]['user_type'];
	$user_id = $r[0]['user_id'];
	$user_school = performQuery("select * from teacher where teacher_id=".$user_id.";");
	$announcements = performQuery('select * from announcement where author_id in (select teacher_id from teacher where Teacher_school_name="'.$user_school[0]['teacher_school_name'].'");');
	$announceNum = mysql_query('select COUNT(announcement_id) from announcement where author_id in (select teacher_id from teacher where Teacher_school_name="'.$user_school[0]['teacher_school_name'].'");');
	$isEmpty = true;
	while($row = mysql_fetch_array($announceNum)){
		if($row['COUNT(announcement_id)'] > 0){
			$isEmpty = false;
		}
	}
?>


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
					<input type="text" id="announcement_title" name="announcement_title" placeholder="Title">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="announcement_content">
					Body
				</label>
				<div class="controls">
					<textarea placeholder="Announcement..." resizable="false" rows="10" name="announcement_content" id="announcement_content">
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

<div id='announcements' class="row-fluid">
	<div class="row-fluid">
			<div class="span9">
				<div class="span3">
					<a  href="#announcementModal"  role="button" class="createlink" data-toggle="modal">
						<i class="icon-plus-sign" id="createcolor"></i> Create Announcement
					</a>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<div class="row-fluid">
						<div class="span9">
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
															posted by:
														<?php
															$query = "select user_fname from user where user_id=".$announcements[$i]['author_id'].";";	
															$fullname = performQuery($query);
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

<!-- Successful add modal -->
<div id="announcement_added" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="announcement_added" aria-hidden="true">
	<div class="modal-header">
		<h3>You have successfully posted an announcement!</h3>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" onclick="okClicked();">Continue</a>
	</div>
</div>

<!-- Successful delete modal -->
<div id="announcement_deleted" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="announcement_deleted" aria-hidden="true">
	<div class="modal-header">
		<h3>You have successfully deleted an announcement!</h3>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" onclick="okClicked();">Continue</a>
	</div>
</div>


<!-- Successful edit modal -->
<div id="announcement_edited" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="announcement_edited" aria-hidden="true">
	<div class="modal-header">
		<h3>You have successfully edited this announcement!</h3>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" onclick="okClicked();">Continue</a>
	</div>
</div>