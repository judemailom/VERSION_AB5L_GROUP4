<?php
include_once 'includes/query.php';

$forum_key = performQuery('SELECT forum_key FROM forum WHERE forum_id = '.$_POST['forum_id'].';');
if($forum_key[0]['forum_key'] == $_POST['forum_key'])
	echo 'OK!';
else
	echo 'NOT OK';
?>