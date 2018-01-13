<div class="container">
	<div class="row">

		<h2>Event comments</h2>
		<p>Check comments for your session courses. Each course has own comments, which are divided by date. In order to comment you need to be registered user.</p>

<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}

include("includes/connection.php");
$counter = 1;


if (isset($_SESSION['courses']) && count($_SESSION['courses']) > 0){

	$query = "SELECT DISTINCT(course_short), course_name FROM `event_comments` group by course_short";

	$collapse_id = 0;
	$col_id = 0;

	//print_r(json_encode($_SESSION['courses']));




	if (mysqli_num_rows(mysqli_query($link, $query))>0){
		if ($result = mysqli_query($link, $query)){
			while ($row = mysqli_fetch_assoc($result)){

				//echo $row['course_short'].'<br>';




			//if (in_array($row['course_short'], $_SESSION['courses'])){
				if (isset($_SESSION['courses'][$row['course_short']])){

					//echo $row['course_short']."<br>";


					echo '<br><div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" >';
					echo '  <div class="panel panel-default">';
					echo '    <div class="panel-heading" role="tab" id="headingOne">';
					echo '      <h4 class="panel-title">';
					echo '        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseID'.$col_id.'" aria-expanded="false" aria-controls="collapseOne">';


					$sql_query3 = "SELECT count(course_short) as course_count from event_comments where course_short='".$row['course_short']."'";
					//echo $sql_query3;
					$course_count1 = 0;
					if ($result3 = mysqli_query($link, $sql_query3)){
						while ($row3 = mysqli_fetch_assoc($result3)){
							$course_count1 = $row3['course_count'];
						}
					}

					echo '<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>';
					echo '           <span class="label label-primary pull-right">'.$course_count1.' comments</span>'.$row['course_short'].' - '.$row['course_name'].' ';
					echo '        </a>';
					echo '      </h4>';
					echo '    </div>';
					echo '    <div id="collapseID'.$col_id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">';
					echo '      <div class="panel-body">';

					$sql_query1 = "SELECT comment_id, course_short, course_name, start_time, DATE_FORMAT(start_time,'%d %M %Y %H:%i') as start_time2, DATE_FORMAT(start_time,'%Y-%m-%d') as start_time3, event_comment, user_id, DATE_FORMAT(comment_timestamp,'%d %M %Y %H:%i:%s') as comment_timestamp  from event_comments where course_short='".$row['course_short']."' order by start_time desc, comment_timestamp asc";
					$prev_ev = "";
					//echo $sql_query1;
					if ($result2 = mysqli_query($link, $sql_query1)){
						while ($row2 = mysqli_fetch_assoc($result2)){
							//echo "loop start <br>";
							if ($prev_ev<>$row2['start_time']){
								if ($prev_ev <> ""){
									echo '</div><br>';
								}


								$sql_query4 = "SELECT count(course_short) as event_count from event_comments where course_short='".$row['course_short']."' and start_time='".$row2['start_time']."'";
								//echo $sql_query4;
								$event_count1 = 0;
								if ($result4 = mysqli_query($link, $sql_query4)){
									while ($row4 = mysqli_fetch_assoc($result4)){
										$event_count1 = $row4['event_count'];
									}
								}

								echo '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>';
								echo '';
								echo '<a href="index.php?page=calendar" type="button" value="submit" onClick="';
								echo "Cookies.set('fullCalendarCurrentDate', '".$row2['start_time3']."', {path: ''});Cookies.set('fullCalendarCurrentView', 'agendaDay', {path: ''});";
								echo '"><b> '.$row2['start_time2'].'</b> </a>';
								echo $row2['course_name'];

								echo ' <a class="btn btn-default btn-sm pull-right" role="button" data-toggle="collapse" href="#collapseExample'.$collapse_id.'" aria-expanded="false" aria-controls="collapseExample"><span class="badge">'.$event_count1.' </span> comments</a>';

								echo '<br><br><div class="collapse" id="collapseExample'.$collapse_id.'"><br>';



								echo '<form action="index.php?page=comments"  role="form" method="post">';
								echo '<input type="hidden" name="course" value="'.$row2['course_short'].'">';
								echo '<input type="hidden" name="event_name" value="'.$row2['course_name'].'">';
								echo '<input type="hidden" name="start_time" value="'.$row2['start_time'].'">';

								echo '<div>';
								echo '<textarea class="form-control" placeholder="Write new comment:" name="event_comment" type="text" required></textarea>';
								echo '</div>';

								echo '<div>';
								echo '<button type="submit" class="btn btn-success pull-right" name="new_event_comment">POST</button> ';
								echo '</div>';
								echo '</form><br>';

							}

							$user_name = "User deleted";
							$sql_query2 = "SELECT username from user_table where uid='".$row2['user_id']."'  ";
							//echo $sql_query2;
							if ($result3 = mysqli_query($link, $sql_query2)){
								while ($row3 = mysqli_fetch_assoc($result3)){
									$user_name = $row3['username'];
									//echo $row3['username'];
								}
							}else {
								# code...
							}

							echo '<span class="glyphicon glyphicon-user" aria-hidden="true"></span> <b>'.$user_name.'</b> wrote on '.$row2['comment_timestamp'].':';
							echo '<p>';
							echo '<div class="well well-sm"><i>';
							echo strip_tags($row2['event_comment'], '');
							echo '</i>';




							if (isset($_SESSION['userID'])){
								if ($row2['user_id']==$_SESSION['userID']){
									echo '<div class="span6 pull-right"><p>';
									echo '<form action="index.php?page=comments" role="form" method="post"><a role="button" href="#" onclick="$(this).closest(\'form\').submit()">';
									echo '<input type=hidden value="'.$row2["comment_id"].'" name="comment_id"> <span class="glyphicon glyphicon-trash"> </span> Delete </a>';
									echo '</form>';
									echo '</p></div>';
								}
							}

							echo '';
							echo '<div class="span6 pull-right"><p>';
							echo '<form action="index.php?page=comments" role="form" method="post"><a role="button" href="#" onclick="$(this).closest(\'form\').submit()">';
							echo '<input type=hidden value="'.$row2["comment_id"].'" name="report_comment_id"> <span class="glyphicon glyphicon-exclamation-sign"> </span> Report </a>';
							echo '</form>';
							echo '</p></div>';

							echo '<br></p>';
							echo '</div>'; #end of well

							if ($prev_ev<>$row2['start_time']){
								$collapse_id += 1;
									//echo "loop END2 <br>";
							}
							$prev_ev = $row2['start_time'];




							//echo "loop END <br>";

						}
					}

					echo '      </div>';
					echo '    </div>';
					echo '  </div>';
					echo '</div>';

					$col_id += 1;

				}else{
					//echo '<p>no comments for session items...</p>';
				}
			}
		}
	}
}



 ?>
</div></div>
