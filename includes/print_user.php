<?php
	
	function printuser($user){
		include "includes/connect.php";
		include "includes/use_db.php";
		$flagy = 0;
		$query1 = "select user_id from user where user_fname'{$user}'";
		$query2 = performQuery("select user_id from user where user_fname'{$user}'");
		$result = mysql_query($query1, $con);
		echo "<form id=viewcl_members method=post action=''><table class='table table-striped' id=viewcl_members>";
		if(mysql_num_rows($result)){
			echo "<tr><th>{$user}</td></tr>";
			$_SESSION['user']=$user;
			$counter=1;
			$counter2=0;
			for($j=0;$j<sizeof($query2);$j++){
				$viewmember = performQuery("select user_fname from user where user_id='{$query2[$j]['user_id']}'");
				//var_dump($viewmember);
				for($i=0;$i<sizeof($viewmember);$i++){
					echo "<tr><td class=body align=left>";
					echo $counter.'. ';
					echo $viewmember[$i]['user_fname'];
					if(isset($_SESSION['delete'])){
						echo "<td><input type=submit name=delete[$counter2] value=Delete /></td>";
					}
					echo "</td></tr>";
					$counter++;
					$counter2++;
				}
			}
		}else {
			echo "<tr><th>{$user}</td></tr>";
			echo "<tr><td>There is no user.</td></tr>";
		}

	}
?>