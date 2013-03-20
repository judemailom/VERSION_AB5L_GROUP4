<?php
	if(!isset($_SESSION['user']))
		header('location: ?page=login');
?>
<div id="add_classlist">
	<div class="row-fluid">
		<div class="span4">
			<form id="view_exam_results" method="post" action="">
				</br></br></br></br><table >
				<?php

		//	$conn = mysql_connect ('localhost', 'root', '') or die ("Connection error.");
		//		mysql_select_db ('ilearn_db', $conn);
					
					$top = performQuery('select * from examresults where author_id = (select user_id from user where user_uname = "'.$_SESSION['user'].'");' );
												
												if($top==NULL){
													echo "no one has taken the exam.";
												}
												else{
												echo "<h1>EXAM RESULTS</h1>";
													echo "<table>";
													echo "<tr>";
													echo "<td>Student ID</td> <td>Score</td>";
													echo "</tr>";
													for($i=0; $i<sizeof($top);$i++){
															echo "<tr>";
															echo "<td> {$top[0]['student_id']}</td> <td>{$top[0]['score']}</td>";
															echo "</tr>";
													
													}
												}
													echo "</table>";
																						
				
				//	mysql_close ($conn);
					
				?>
				</table>
			</form>
		</div>
	</div>
</div> 
