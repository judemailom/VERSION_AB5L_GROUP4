<?php
	
//	echo '<br />';
	$query =  'select user_type from user where user_uname = "'.$_SESSION['user'].'";';
	$r = performQuery($query);
	$user_type = $r[0]['user_type'];
	$r = performQuery('select '.$user_type.'_school_name from '.$user_type.' where '.$user_type.'_id = (select user_id from user where user_uname = "'.$_SESSION['user'].'");');
	$user_school = $r[0][$user_type.'_school_name'];
	$announcements = performQuery('select * from announcement where author_id = (select teacher_id from teacher where teacher_school_name="'.$user_school.'" group by teacher_school_name);');
//	var_dump($announcements);
?>
<div id='announcements'>
	<?php
		if($user_type == 'Teacher' || $user_type == 'Administrator'){
	?>
		<div class="row-fluid">
			<div class="span10">
			<div class="span2">
				<div id="post_button">
					<form action="?page=add_announcement" method="post" id="announcement">
						<input type="submit" value="Post an announcement" name="add_announcement" />
					</form>
				</div>
			</div>
		</div>
	<?php
		}
	?>
	<div class="row-fluid">
		<div class="span12">
			<?php 
				for($i=0;$i<sizeof($announcements);$i++){
			?>
				<div class="row-fluid">
					<div class="span10">
						<div class="announcement">
							<div class="header">
								<?php echo $announcements[$i]['announcement_title']; 
										?>
							</div>
							<div class="announcement_details">
								posted by: 
								<?php
								$author = performQuery('select user_fname from user where user_id = '.$announcements[$i]['author_id'].';');
								echo $author[0]['user_fname'];
								?>
							</div>
							<div class="content">
								<?php echo $announcements[$i]['announcement_content']; ?>
							</div>
						</div>
					</div>
				</div>
			<?php }?>
		</div>
	</div>
</div>