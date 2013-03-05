<?php
	function performQuery($query){
		$link = new mysqli('localhost','root', '', 'ilearn_db') or die('cannot connect  to database server.');
		$_results = $link->query($query);
		$link->close();

		if(gettype($_results) != "boolean" && ($_results->num_rows)>0){
			$data = array();	
			while($row = $_results->fetch_assoc())
				$data[]=$row;
			mysqli_free_result($_results);
			return $data;
		}
		return $_results;
	}
?>