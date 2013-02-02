<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	$USER = performQuery( "SELECT * FROM USER WHERE _username='"./*$_SESSION['user']*/'user1'."';");
	$UserForums = performQuery("SELECT * FROM FORUM_MEMBERS WHERE _username='user1';");
	var_dump($UserForums);
?>

<div id="forums">
	<div class="row-fluid">
		<div class="span12">
			<div class="span9">
				<div class="containerDiv">
					<p class="title_header"><?php echo $USER[0]['_fullname']."'s (".$USER[0]['_username'].") Forums" ?></p>
					<div class="row-fluid">
						<div class="span12" style="border-bottom: 1px solid #323232; text-align: center;">
							<div class="span4">
								Forum Name
							</div>
							<div class="span4">
								Created by
							</div>
							<div class="span4">
								Actions
							</div>
						</div>
						<?php
							for($i=0;$i<sizeOf($UserForums);$i++){ ?>
								<div class="row-fluid">
									<div class="span12" style="border-bottom: 1px solid #323232; text-align: center;">
										<div class="span4"><?php echo $UserForums[$i]['_title']; ?></div>
										<div class="span4"><?php										?></div>
										<div class="span4"></div>
									</div>
								</div>
						<?php } ?>
					</div>
				</div>	
			</div>	
		</div>	
	</div>
</div>