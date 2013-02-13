<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	$USER = performQuery( "SELECT * FROM user WHERE user_uname='".$_SESSION['user']."';");
	$UserForums = performQuery('SELECT * FROM forum_members WHERE user_uname="'.$_SESSION['user'].'";');
	var_dump($UserForums);
?>	

<div id="forums">
	<div class="row-fluid">
		<div class="span12">
			<div class="span9">
				<div class="containerDiv">
					<div class="row-fluid">
						<div class="span12" style="border-bottom: 1px solid #323232; text-align: center;">
							<div class="span4">
								Forum Name
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
										<div class="span4">
											<form action="" method="post">
												<div class="span2">
													<input type="submit" value="Enter Forum" />
												</div>
												<div class="span2">
													<input type="submit" value="View Members" />
												</div>
											</form>
										</div>
									</div>
								</div>
						<?php } ?>
					</div>
				</div>	
			</div>	
		</div>	
	</div>
</div>