<?php
	require_once "includes/connect.php";
	require_once "includes/use_db.php";
	require_once "includes/query.php";

	$query =  'select * from user where user_uname = "'.$_SESSION['user'].'";';
	$r = performQuery($query);
	$user_type = $r[0]['user_type'];
	$user_id = $r[0]['user_id'];
	$user_school = performQuery('select Student_school from student where student_id='.$user_id.';');

	$announcements = performQuery("select * from announcement where author_id in (select teacher_id from teacher where Teacher_school='".$user_school[0]['Student_school']."');");
	$query = "select COUNT(announcement_id) from announcement where author_id in (select teacher_id from teacher where Teacher_school='".$user_school[0]['Student_school']."');";
	$announceNum = mysql_query($query);
	$isEmpty = true;

	while($row = mysql_fetch_array($announceNum)){
		if($row['COUNT(announcement_id)'] > 0){
			$isEmpty = false;
		}
		else {

			$isEmpty = true;
		}
	}
?>


<?php
	if($user_type == 'Teacher' || $user_type == 'Administrator')
		header('location: ?page=add_announcement');
	else{
?>
<div id='announcements' class="row-fluid">

		<div class="row-fluid">
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
 											for($i=0;$i<sizeof($announcements);$i++){
 												//if($user_school == $teacher_school){
													if($i == 0){
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
													</div>
												</div>
									<?php
											}
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
<?php
	}
?>