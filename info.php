
<div class="container">

	<div class="row">

<?php

	if (isset($_SESSION)){
	}else{
		header("location: index.php");
	}


  if (isset($_SESSION['courses']) && count($_SESSION['courses']) > 0){


	include("includes/connection.php");
	//Output all user courses from DB
	$query="SELECT start_time, course, event_name FROM timetable WHERE course IN (";
	foreach($_SESSION['courses'] as $id => $value){
		$query.="'".$id."',";
	}
	$query=substr($query, 0, -1).") and event_active = 1 and event_type <> 'EXAM' group BY course order by end_time asc, start_time asc";
	//echo $query;


	echo '<h2>Session course info</h2>';
	echo '<p>Remember to also check info from Weboodi</p>';
	//echo $query;

	if (mysqli_num_rows(mysqli_query($link, $query))>0){
		if ($result = mysqli_query($link, $query)){



			while ($row = mysqli_fetch_assoc($result)){

				// echo $row["start_time"].'<br>';

			echo	'<div class="col-md-4">';
			echo	'<div class="panel panel-default">';
					echo	'<div class="panel-heading">';
					echo '<b>'.$row["course"].'</b> <br><i>'.$row["event_name"].'</i>';
					echo '</div>';

					echo '<div class="panel-body">';

					//Count how many events in total where course = ?
					$event_count = 0;
					$max_start;
					$min_start;
					$query2='SELECT count(id) as event_count, DATE_FORMAT(min(start_time), "%d.%m.%Y") as start_time, DATE_FORMAT(max(start_time), "%d.%m.%Y") as end_time FROM timetable WHERE course ="'.$row["course"].'" and event_type <> "EXAM" and event_type <> "INACTIVE"';
				//	echo $query2;
					if (mysqli_num_rows(mysqli_query($link, $query2))>0){
						if ($result2 = mysqli_query($link, $query2)){
							while ($row2 = mysqli_fetch_assoc($result2)){
								$event_count = $row2['event_count'];
								$min_start = $row2['start_time'];
								$max_start = $row2['end_time'];
							}
						}
					}
					echo $min_start.' - '.$max_start.'<br>';
					//echo "<br>Event count: ".$event_count.'<br>';
					//Count how many events left in total where course = ?
					$events_left = 0;
					$query2='SELECT count(id) as events_left FROM timetable WHERE start_time > now() and course ="'.$row["course"].'" and event_type <> "EXAM" and event_type <> "INACTIVE"';
					//echo $query2;
					if (mysqli_num_rows(mysqli_query($link, $query2))>0){
						if ($result2 = mysqli_query($link, $query2)){
							while ($row2 = mysqli_fetch_assoc($result2)){
								$events_left = $row2['events_left'];
							}
						}
					}

					//echo "<br>Events left: ".$events_left.'<br>';

					$progress_bar_color = "progress-bar progress-bar-success";
					$progress = 0;

					if ($events_left == $event_count){ //event not started
						$progress_bar_color = "progress-bar progress-bar-warning";
						$progress = 100;
						$text = "Not yet started (".$event_count." events)";
						//echo $text;
					}elseif ($events_left < $event_count && $events_left > 0) { // event ongoing
						$progress_bar_color = "progress-bar progress-bar-info";
						$progress = round((($event_count -$events_left) / $event_count)*100, 0);
						$text = ($event_count - $events_left) .' / '. $event_count. ' ';
					}elseif ($events_left == 0) { //event ended
						$progress_bar_color = "progress-bar progress-bar-success";
						$progress = 100;
						$text = "Ready! (".($event_count - $events_left) .' / '. $event_count. ')';
					}

					echo '<div class="progress">';
					echo '	<div class="'.$progress_bar_color.'" role="progressbar" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$progress.'%;">';
					echo $text;
					echo '	</div>';
					echo '</div>';


					echo '<a href="includes/weboodi_info_modal.php?course_code='.substr($row["course"],0,9).'" data-target="#courseinfo" class="btn btn-default" role="button" data-toggle="modal" >Check info</a>';

					echo '<form class="pull-right" action="'.$app_path.''.$_page.'" method="post">';
					echo '<input type="hidden" name="remove_course_from_session">';
					echo '<input type="hidden" name="course_id" value='.str_replace(' ','_',$row["course"]).'>';
					echo '<input class="btn btn-danger" type="submit" value="Remove">';
					echo '</form>';


					echo '</div>';
					echo '</div>';
					echo '</div>';

			}

		}
	}else {
		echo "No courses!";
	}
}

 ?>
</div>
</div>
<!-- Event Modal -->
<div id="courseinfo" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Weboodi info</h4>
			</div>
			<div class="modal-body">
					<p>Loading...</p>
			</div>
			<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- Event modal -->
