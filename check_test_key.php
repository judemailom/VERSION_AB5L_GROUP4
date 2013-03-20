<?php
	session_start();
	include 'includes/query.php';

	//var_dump($_POST);
	$test_key = performQuery('SELECT test_key FROM test WHERE test_id = '.$_POST['test_id'].';');
	if($_POST['test_key'] == $test_key[0]['test_key']){ 
		$_SESSION['test_id'] = $_POST['test_id'];
		$_SESSION['taking_exam'] = 1;
		?>
		<script>
			window.location = '?page=take_exam';
		</script>
<?php	}
else{ ?>
		<div class="alert alert-error">
			Test key is invalid.
		</div>
<?php } ?>