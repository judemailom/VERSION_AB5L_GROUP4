<?php
	
	function printClasslist($classlist){
		include "includes/connect.php";
		include "includes/use_db.php";
		$flagy = 0;
		$query1 = "select classlist_user_id from classlist_members where classlist_id=(SELECT classlist_id from classlist where classlist_name='{$classlist}')";
		$query2 = performQuery("select classlist_user_id from classlist_members where classlist_id=(SELECT classlist_id from classlist where classlist_name='{$classlist}')");
		$result = mysql_query($query1, $con);
		echo "<form id=viewcl_members method=post action=''><table class='table table-striped' id=viewcl_members>";
		if(mysql_num_rows($result)){
			echo "<tr><th>{$classlist}</td></tr>";
			$_SESSION['classlist']=$classlist;
			$counter=1;
			$counter2=0;
			for($j=0;$j<sizeof($query2);$j++){
				$viewmember = performQuery("select user_fname from user where user_id='{$query2[$j]['classlist_user_id']}'");
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
			echo "<tr><th>{$classlist}</td></tr>";
			echo "<tr><td>There are no members in the classlist.</td></tr>";
		}

	}
?>