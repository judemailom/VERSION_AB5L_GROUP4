<?php 
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
	// var_dump($_GET);
	$test_id = $_GET['test_id'];
	$test =  performQuery("SELECT * FROM TEST WHERE TEST_ID = $test_id");
	$classlists = performQuery('SELECT classlist_name FROM classlist WHERE classlist_id IN (SELECT classlist_id FROM test_classlist WHERE test_id = '.$test[0]['test_id'].');');
	$author = performQuery('SELECT user_uname FROM user WHERE user_id = '.$test[0]['test_author_id'].';');
	//var_dump($author);
?>
<div id="view_test">
	<div class="container-fluid">
		<div class="row-fluid">
			<h3><?php echo $test[0]['test_name']; ?></h3>
		</div>
		<div class="row-fluid">
			Published on <?php echo $test[0]['test_date_upload']; ?> with a deadline of <?php echo $test[0]['test_date_deadline']; ?><br />
			For classlists 
			<?php
			for($j=0;$j<sizeof($classlists);$j++){
				if(!isset($classlists->num_rows))
					echo " ".$classlists[$j]['classlist_name'];
				}
			?>
		</div>
		<div class="row-fluid">
			<?php echo $test[0]['test_length']; ?> items
		</div>
		<div class="row-fluid">
			Posted by <?php echo $author[0]['user_uname']; ?>
		</div>
		<?php
			for($i=1;$i<=$test[0]['test_length'];$i++){ ?>
				<div class="row-fluid">
					<h3>Question <?php echo $i; ?></h3>
				</div>
				<div class="row-fluid">
					<?php 
					$a = performQuery( 'SELECT question FROM question WHERE test_id = '.$test_id.' AND test_item_number = '.$i.';');
					echo $a[0]['question'];
					?>
				</div>
				<div class="row-fluid">
					A. <?php 
						$a = performQuery( 'SELECT test_choice_a FROM question WHERE test_id = '.$test_id.' AND test_item_number = '.$i.';');
					echo $a[0]['test_choice_a'];
					?>
				</div>
				<div class="row-fluid">
					B. <?php 
						$a = performQuery( 'SELECT test_choice_b FROM question WHERE test_id = '.$test_id.' AND test_item_number = '.$i.';');
					echo $a[0]['test_choice_b'];
					?>
				</div>
				<div class="row-fluid">
					C. <?php 
						$a = performQuery( 'SELECT test_choice_c FROM question WHERE test_id = '.$test_id.' AND test_item_number = '.$i.';');
					echo $a[0]['test_choice_c'];
					?>
				</div>
				<div class="row-fluid">
					D. <?php 
						$a = performQuery( 'SELECT test_choice_d FROM question WHERE test_id = '.$test_id.' AND test_item_number = '.$i.';');
					echo $a[0]['test_choice_d'];
					?>
				</div>
				<?php	if($_SESSION['user_type'] != 'Student'){	?>
				<div class="row-fluid">
					Answer: <?php 
						$a = performQuery('SELECT test_correct_answer FROM question WHERE test_id = '.$test_id.' AND test_item_number = '.$i.';');
					echo $a[0]['test_correct_answer'];
					?>
				</div>
				<?php	}	?>
		<?php
		}
		?>
	</div>
</div>