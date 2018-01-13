<div class="container">
	<div class="row">

		<?php
		if (isset($_SESSION)){
					include("includes/connection.php");
		}else{
			header("location: calendar");
		}

		if (isset($_POST['delete_course_from_db']) && isset($_SESSION['userID'])){

			// Create connection
			$conn = new mysqli($server, $user, $pass, $db);

			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}

			$course_id = str_replace('_', ' ', $_POST['delete_course_from_db']);
			//echo $course_id;

			$stmt = $conn->prepare("DELETE FROM user_courses where user_id=? and course_id=?");
			$stmt->bind_param("is", $_SESSION['userID'], $course_id);
			$stmt->execute();


			echo '<div class="alert alert-success fade in">';
			echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		  echo "<strong> {$course_id} </strong> was removed from you courses";
			echo '</div>';

			if (isset($_SESSION['courses'][$course_id])){
				unset($_SESSION['courses'][$course_id]);
			}

			//echo "New records created successfully";

			$stmt->close();
			$conn->close();

			//unset($_POST['delete_course_from_db']);
		}





?>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#courses" aria-controls="courses" role="tab" data-toggle="tab">Courses</a></li>
		<?php
			if ($_SESSION['userID']==29){
		    echo '<li role="presentation"><a href="#search_statistics" aria-controls="search_statistics" role="tab" data-toggle="tab">Searches</a></li>';
				echo '<li role="presentation"><a href="#course_statistics" aria-controls="course_statistics" role="tab" data-toggle="tab">Courses</a></li>';
				echo '<li role="presentation"><a href="#statistics" aria-controls="statistics" role="tab" data-toggle="tab">Statistics</a></li>';

			}
		?>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane <?php if ($_SESSION['username']<>'allu_mallu'){echo 'active';} ?>" id="home">

			<h2>User: <?php if (isset($_SESSION['username'])){ echo $_SESSION['username']; } ?>:</h2>
			<?php
			//Output all user courses from DB
			$user_id = $_SESSION['userID'];
			$query = "SELECT registered_on FROM user_table where uid=$user_id ";
	    if (mysqli_num_rows(mysqli_query($link, $query))>0){
	      if ($result = mysqli_query($link, $query)){
					while ($row = mysqli_fetch_assoc($result)){
						echo '<p>Member since: '.$row['registered_on'].'</p>';
					}
	      }
	    }

			$sql = "SELECT ip_address, DATE_FORMAT(login_time,'%d.%m.%Y %H:%i') as log1 FROM user_login_log WHERE user_id=? ORDER BY login_time desc limit 10";
			if ($stmt = mysqli_prepare($link, $sql)) {
			  $stmt->bind_param("i", $_SESSION['userID']);
			  $stmt->execute();
			  mysqli_stmt_bind_result($stmt, $ip_address, $login_time);


				echo '<h3>10 latest logins:</h3>';
			  echo '<table class="table table-hover">';
				echo '<tr>';
				echo '<th>IP</th>';
				echo '<th>Time</th>';
				echo "</tr>";
			  while (mysqli_stmt_fetch($stmt)) {
			    echo "<tr>";
			    echo "<td>".$ip_address."</td>";
			    echo "<td>".$login_time."</td>";
			    echo "</tr>";
			  }
			  echo "</table>";

			  mysqli_stmt_close($stmt);
			}






		 ?>
		</div>

    <div role="tabpanel" class="tab-pane" id="courses">

			<?php

			echo '<h3>Your saved courses:</h3>';
			echo '<p>Here you can see all your courses in database, add them back and check session items</p>';
			echo '<table class="table table-striped">';
			echo '<tr>';
			echo '<th>Course</th>';
			echo '<th>Database</th>';
			echo '<th>Session</th>';
			echo '<th>Delete</th>';
			echo "</tr>";

			if (isset($_SESSION['courses'])){

			foreach ($_SESSION['courses'] as $course_id => $course_name) {

				$query = "SELECT course_id, (SELECT event_name from timetable WHERE course=course_id limit 1) as course_name, DATE_FORMAT(added_on,'%D %M %Y') as added_on, active FROM user_courses where user_id=$user_id and course_id='{$course_id}' group by course_id order by active desc, course_name desc";
				//echo $query;
				if ($result = mysqli_query($link, $query)){
				if (mysqli_num_rows(mysqli_query($link, $query))>0){
					while ($row = mysqli_fetch_assoc($result)){
						echo '<tr>';
						echo '<td>'.$row['course_id'].' - '.$row['course_name'].'<br> ('.$row['added_on'].')</td>';
						echo '<td><span class="glyphicon glyphicon-ok" style="color: orange"> </span></td>';
						echo '<td><span class="glyphicon glyphicon-star" style="color: orange"> </span></td>';

						echo '<td><form class="form-inline" action="'.$app_path.'settings" method="post">';
						echo '<input type="hidden" name="delete_course_from_db" value='.str_replace(' ','_',$row['course_id']).'>';
						echo '<input class="btn btn-danger" type="submit" value="Remove"></form></td>';

						echo "</tr>";
					}
				}else {
						echo '<tr>';
						echo '<td>'.$course_name.'<br> (not saved)</td>';
						echo '<td><span class="glyphicon glyphicon-remove" ></span></td>';
						echo '<td><span class="glyphicon glyphicon-star" style="color: orange"></span></td>';
						echo '<td> - </td>';

						echo "</tr>";
				}
			}

			}
			}

			$query = "SELECT course_id, (SELECT event_name from timetable WHERE course=course_id limit 1) as course_name, DATE_FORMAT(added_on,'%D %M %Y') as added_on, active FROM user_courses where user_id=$user_id group by course_id order by active desc, course_name desc";
			//echo $query;


			if ($result = mysqli_query($link, $query)){
				while ($row = mysqli_fetch_assoc($result)){

					if (!isset($_SESSION['courses'][$row['course_id']])){
						echo '<tr>';
						echo '<td>'.$row['course_id'].' - '.$row['course_name'].'<br> ('.$row['added_on'].')</td>';
						echo '<td>';

						if ($row['active']==0){
							echo '<span class="glyphicon glyphicon-remove"> </span>';
						}else{
							echo '<span class="glyphicon glyphicon-ok" style="color: orange"> </span>';
						}
						echo '</td>';
						echo '<td><span class="glyphicon glyphicon-star-empty"> </span></td>';

						echo '<td><form class="form-inline" action="'.$app_path.'settings" method="post">';
						echo '<input type="hidden" name="delete_course_from_db" value='.str_replace(' ','_',$row['course_id']).'>';
						echo '<input class="btn btn-danger" type="submit" value="Remove"></form></td>';


						echo "</tr>";
					}

				}
			}
			echo '</table>';
			 ?>

		</div>

    <div role="tabpanel" class="tab-pane <?php if ($_SESSION['username']=='allu_mallu'){echo 'active';} ?>" id="search_statistics">
			<?php
				if ($_SESSION['userID']==29){
					//echo $app_path.'includes/classes.class.php';

					echo '<h1>CourseSearch tilastot: </h1>';
					echo '<div class="row">';

					echo '<a href="'.$app_path.'settings#cs1"> 1) Course statistics </a> <br>';
					echo '<a href="'.$app_path.'settings#stats2"> 2) Search statistics </a> <br>';


					echo '<div class="col-md-6">';
					echo '<h2>Data</h2>';
					echo '<table class="table table-striped">';

					echo '<tr><th>Type</th><th>Today</th><th>Total</th></tr>';

					$query = "SELECT count(ip_address) as stat1 FROM course_search_history where DATE(time_of_search) = DATE(NOW())";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td>Coursesearches</td><td><div class="numberCircle">'.$row['stat1'].'</div> </td>';
						}
					}


					$query = "SELECT count(ip_address) as stat1 FROM course_search_history";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<td><div class="numberCircle">'.$row['stat1'].'</div> </td></tr>';
						}
					}

					$query = "select count(distinct(ip_address)) as stat1 from course_search_history where DATE(time_of_search) = DATE(NOW())";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td> Visitors  </td><td><div class="numberCircle">'.$row['stat1'].'</div> </td>';
						}
					}

					$query = "SELECT count(distinct(ip_address)) as stat1 FROM course_search_history";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<td><div class="numberCircle">'.$row['stat1'].'</div></td></tr> ';
						}
					}

					$query = "SELECT count(ip_address) as stat1 from visitors where DATE(visiting_time) = DATE(NOW())";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td> Pageclicks </td><td><div class="numberCircle">'.$row['stat1'].'</div> </td>';
						}
					}

					$query = "SELECT count(ip_address) as stat1 FROM visitors";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<td><div class="numberCircle">'.$row['stat1'].'</div></td></tr> ';
						}
					}


					$query = "SELECT count(distinct(ip_address)) as stat1 from visitors where DATE(visiting_time) = DATE(NOW())";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td> Unique pageclicks  </td><td><div class="numberCircle">'.$row['stat1'].'</div> </td>';
						}
					}

					$query = "SELECT count(distinct(ip_address)) as stat1 FROM visitors";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<td><div class="numberCircle">'.$row['stat1'].'</div></td></tr> ';
						}
					}

					$query = "SELECT count(distinct(uid)) as stat1 FROM user_table where DATE(registered_on)=CURDATE()";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td>Registered </td><td><div class="numberCircle">'.$row['stat1'].'</div></td>';
						}
					}


					$query = "SELECT count(distinct(uid)) as stat1 FROM user_table";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<td> <div class="numberCircle">'.$row['stat1'].'</div> </td></tr>';
						}
					}

					$query = "SELECT count(course_id) as stat1 FROM `user_courses` where DATE(added_on) = CURDATE()";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td>Saved courses </td><td><div class="numberCircle">'.$row['stat1'].'</div> </td>';
						}
					}

					$query = "SELECT count(course_id)  as stat1 FROM `user_courses`";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<td><div class="numberCircle">'.$row['stat1'].'</div></td></tr> ';
						}
					}

					$query = "SELECT count(comment_id) as stat1 FROM `event_comments` where date(comment_timestamp)=CURDATE()";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td>Comments </td><td><div class="numberCircle">'.$row['stat1'].'</div> </td>';
						}
					}

					$query = "SELECT count(comment_id) as stat1 FROM `event_comments`";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<td><div class="numberCircle">'.$row['stat1'].'</div> </td></tr>';
						}
					}


					$query = "SELECT count(login_id) as stat1 FROM `user_login_log` where date(login_time)=CURDATE()";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td>Logins </td><td><div class="numberCircle">'.$row['stat1'].'</div> </td>';
						}
					}

					$query = "SELECT count(login_id) as stat1 FROM `user_login_log`";
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<td><div class="numberCircle">'.$row['stat1'].'</div> </td></tr>';
						}
					}

					echo '</table>';
					echo '</div>';


					$query = "SELECT distinct(course_name) as course, count(*) as course_count FROM `course_search_history` where DATE(time_of_search) = DATE(NOW()) group by course_name order by course_count desc, course_name asc limit 10";
					if ($result = mysqli_query($link, $query)){
						echo '<div class="col-md-6">';
						echo '<h2>TOP Courseseaches today</h2>';
						echo '<table class="table table-striped">';
						echo '<tr>';
						echo '<th>Course</th>';
						echo '<th>Count</th>';
						echo '</tr>';
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr>';
							echo '<td>'.$row['course'].'</td>';
							echo '<td><div class="numberCircle">'.$row['course_count'].'</div></td>';

							echo '</tr>';
						}
						echo '</table>';
						echo '</div>';
					}



					echo '</div>';




					echo '<div class="row">';

					$query = "SELECT ip_address as stat1, visiting_time FROM visitors group by visiting_time order by visiting_time desc limit 5";
					//echo $query;
					if ($result = mysqli_query($link, $query)){
						echo '<div class="col-md-6">';
						echo '<h2>Last 5 Ip-addresses pageclicks</h2> ';
						echo '<table class="table table-striped">';
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td><a href="http://whatismyipaddress.com/ip/'.$row['stat1'].'" target="_blank">'.$row['stat1'].'</a></td><td> '.$row['visiting_time'].'</td></td>';
						}
						echo '</table>';
						echo '</div>';
					}

					//echo '</div>';

					$query = "SELECT ip_address as stat1, time_of_search FROM course_search_history group by time_of_search order by time_of_search desc limit 5";
					//echo $query;
					if ($result = mysqli_query($link, $query)){
						echo '<div class="col-md-6">';
						echo '<h2>Last 5 Ip-addresses coursesearch</h2> ';
						echo '<table class="table table-striped">';
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr><td><a href="http://whatismyipaddress.com/ip/'.$row['stat1'].'" target="_blank">'.$row['stat1'].'</a></td><td> '.$row['time_of_search'].'</td></td>';
						}
						echo '</table>';
						echo '</div>';
					}

					echo '</div>';





					echo '<div class="row">';

					$query = "SELECT user_id, user_name, ip_address as stat1, login_time from user_login_log order by login_time desc limit 10";
					if ($result = mysqli_query($link, $query)){
						echo '<div class="col-md-6">';
						echo '<h2 id="users">Latest logins</h2>';
						echo '<table class="table table-striped">';
						echo '<tr>';
						//echo '<th>Course</th>';
						echo '<th>User name</th>';
						echo '<th>Login time</th>';
						echo '<th>IP</th>';
						echo '</tr>';

						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr>';
						//  echo '<td>'.$row['course_id'].'</td>';
							echo '<td><a href="'.$app_path.'settings/'.$row['user_id'].'">'.$row['user_name'].' </a></td>';
							echo '<td>'.$row['login_time'].'</td>';
							echo '<td><a href="http://whatismyipaddress.com/ip/'.$row['stat1'].'" target="_blank">'.$row['stat1'].'</a></td>';

							echo '</tr>';
						}
						echo '</table>';
						echo '</div>';
					}


					class course_type {

						private $course_id;

						function return_type($course_id){

							$course_id_array = array(
							 "BH"=>"Ente",
							 "A"=>"Kati",
							 "LM"=>"Kati",
							 "BJ"=>"Kete",
							 "FV"=>"Kike",
							 "BK"=>"Kote",
							 "BM"=>"Mafy",
							 "BL"=>"Sate",
							 "CT"=>"Tite",
							 "CS"=>"Tuta",
							 "BH60"=>"Ymte"
							);



							foreach ($course_id_array as $v => $value){

								if (substr($course_id, 0, strlen($v)) == $v){
									return $value;
								}
								// echo '<br>';
							}
						}
					}

					$query = "SELECT course_name as course FROM `course_search_history`  order by course_name asc";
					//echo $query;
					$course_type_array = array();
					$course = new course_type();
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							$type = $course->return_type($row['course']);
							//echo $type;
							if (array_key_exists($type, $course_type_array)){
								$course_type_array[$type] += 1;
							}else{
								$course_type_array[$type] = 1;
							}
						}
					}

					arsort($course_type_array);

					echo '<div class="col-md-6">';
					echo '<h2>Searched coursetypes</h2>';
					echo '<table class="table table-striped">';
					echo '<tr>';
					echo '<th>Course</th>';
					echo '<th>User</th>';
					echo '</tr>';
					foreach ($course_type_array as $v => $value){

						echo '<tr>';
						echo '<td>'.$v.'</td>';
						echo '<td>'.$value.'</td>';
						echo '</tr>';

					}
					echo '</table>';
					echo '</div>';






					echo '<div class="col-md-6">';
					echo '<h2>Kaikki kurssihaut</h2>';
					$query = "SELECT distinct(course_name) as course, count(*) as course_count FROM `course_search_history` group by course_name order by course_count desc, course_name asc limit 10";
					//echo $query;

					echo '<table class="table table-striped">';
					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<tr>';
							echo '<td>'.$row['course'].'</td>';
							echo '<td>'.$row['course_count'].'</td>';
							echo '</tr>';
						}
					}
					echo '</table>';
					echo '</div>';

					echo '<div class="col-md-6">';
					echo '<h2>Viimeisimmät kommentit</h2>';
					$query = "SELECT comment_id, course_short, course_name, start_time, event_comment, (select username from user_table where user_id=uid) as username, user_id, comment_timestamp FROM `event_comments` order by comment_timestamp desc limit 3";
					//echo $query;

					if ($result = mysqli_query($link, $query)){
						while ($row = mysqli_fetch_assoc($result)){
							echo '<hr><b>'.$row['comment_id'].' - ';
							echo ''.$row['course_short'].' - ';
							echo ''.$row['course_name'].'</b> at ';
							echo ''.$row['start_time'].' <br> ';
							echo '<div class="well"><i>'.$row['event_comment'].'</i></div>';
							echo 'Written by <b>'.$row['username'].'</b> ('.$row['user_id'].') at ';
							echo ''.$row['comment_timestamp'].'<br>';
						}
					}
					echo '</div>';


					echo '</div>';

				}
			 ?>
		</div>

    <div role="tabpanel" class="tab-pane" id="course_statistics">
			<?php
			if ($_SESSION['userID']==29){

				echo '<h2 id="cs1">CourseSearch tilastot:</h2>';

				$query = "SELECT count(course) as stat1 FROM timetable";
				//echo $query;
				if ($result = mysqli_query($link, $query)){
					while ($row = mysqli_fetch_assoc($result)){
						echo 'All courses <span class="label label-default">'.$row['stat1'].'</span> ';
					}
				}

				$query = "SELECT count(course) as stat1 FROM timetable where YEARWEEK(start_time) = YEARWEEK(NOW())";
				//echo $query;
				if ($result = mysqli_query($link, $query)){
					while ($row = mysqli_fetch_assoc($result)){
						echo ' This week <span class="label label-default">'.$row['stat1'].' </span> ';
					}
				}

				$query = "SELECT count(course) as stat1 FROM timetable where DATE(start_time) = CURDATE()";
				//echo $query;
				if ($result = mysqli_query($link, $query)){
					while ($row = mysqli_fetch_assoc($result)){
						echo ' Today <span class="label label-default">'.$row['stat1'].' </span> ';
					}
				}

				echo '<hr>';
				 echo '<div class="row"><div class="col-md-9"><h2>In 2 hours</h2> ';
				 $query = "SELECT course, event_name, event_type, event_location, DATE_FORMAT(start_time,'%H:%i') as start_time, DATE_FORMAT(end_time,'%H:%i') as end_time, (SELECT count(course_id) from user_courses where course=course_id) as stat1 FROM timetable WHERE start_time BETWEEN NOW() + INTERVAL 3 HOUR AND NOW() + INTERVAL 5 HOUR order by  start_time asc, stat1 desc";
				 //echo $query;

				 if ($result = mysqli_query($link, $query)){
					 echo '<table class="table table-striped">';
					 echo '<tr>';
					 echo '<th>Course</th>';
					 echo '<th>location</th>';
					 echo '<th>Users</th>';
					 echo '</tr>';

					 while ($row = mysqli_fetch_assoc($result)){
						 echo '<tr>';
						 echo '<td>'.$row['start_time'].' - '.$row['end_time'].' <br>'.$row['course'].' - '.$row['event_name'].' ('.$row['event_type'].')<br>';

						 $query2 = "SELECT (SELECT username FROM user_table where user_id=uid) as user_name, user_id from user_courses where active=1 and course_id = '{$row['course']}' ";
						 //echo $query2;

						 if ($result2 = mysqli_query($link, $query2)){
							 while ($row2 = mysqli_fetch_assoc($result2)){
								 echo '<a href="'.$app_path.'settings/'.$row2['user_id'].'">'.$row2['user_name'].'</a>; ';
							 }
						 }
						 echo '</td>';
						 echo '<td><a href="http://coursesearch.esy.es/index.php?page=room_schedule&room_name='.$row['event_location'].'"> '.$row['event_location'].'</a> </td>';
						 echo '<td>'.$row['stat1'].'</td>';
						 echo '</tr>';
					 }
					 echo '</table></div>';
				 }

				echo '<div class="col-md-3"><h2>Event types</h2> ';
				$query = "SELECT event_type, count(*) FROM `timetable` group by event_type order by count(*) desc";
				//echo $query;

				if ($result = mysqli_query($link, $query)){
					echo '<table class="table table-striped">';
					while ($row = mysqli_fetch_assoc($result)){
						echo '<tr>';
						echo '<td>'.$row['event_type'].'</td><td>'.$row['count(*)'].'</td>';
						echo '</tr>';
					}
					echo '</table></div></div>';
				}

				echo '<div class="row"><div class="col-md-6"><h2>Latest courses</h2> ';
				$query = "SELECT course, event_name, event_type, count(course), first_insert FROM `timetable` group by course, event_name, event_type, first_insert ORDER BY `timetable`.`first_insert` DESC, course desc  limit 10";

				if ($result = mysqli_query($link, $query)){
					echo '<table class="table table-striped">';
					echo '<tr>';
					echo '<th>Course</th>';
					echo '<th>Count</th>';
					echo '<th>Impact</th>';


					echo '</tr>';
					while ($row = mysqli_fetch_assoc($result)){
						echo '<tr>';
						echo '<td>'.$row['first_insert'].'<br>'.$row['course'].' - '.$row['event_name'].' ('.$row['event_type'].')';
						$query2 = "SELECT (SELECT username FROM user_table where user_id=uid) as user_name, user_id from user_courses where active=1 and course_id = '{$row['course']}' ";
						//echo $query2;
						if ($result2 = mysqli_query($link, $query2)){
							while ($row2 = mysqli_fetch_assoc($result2)){
								echo '<br><a href="'.$app_path.'settings/'.$row2['user_id'].'">'.$row2['user_name'].'</a>; ';
							}
						}
						echo '</td>';
						$query2 = "SELECT count(course_name) as stat1 from course_search_history where course_name = '{$row['course']} - {$row['event_name']}' ";
						//echo $query2;
						if ($result2 = mysqli_query($link, $query2)){
							while ($row2 = mysqli_fetch_assoc($result2)){
								echo '<td>'.$row2['stat1'].'</td>';
							}
						}
						echo '<td>'.$row['count(course)'].'</td>';
						echo '</tr>';
					}
					echo '</table></div>';
				}

				echo '<div class="col-md-6"><h2>Latest inactivated courses</h2>';
				$query = "SELECT course, count(course), event_name, event_type, update_timestamp FROM `timetable` where event_active=0 group by course, event_name, event_type, update_timestamp ORDER BY `timetable`.`update_timestamp` DESC, course desc limit 10";

				if ($result = mysqli_query($link, $query)){
					echo '<table class="table table-striped">';
					echo '<tr>';
					echo '<th>Course</th>';
					echo '<th>Count</th>';
					echo '<th>Impact</th>';

					echo '</tr>';
					while ($row = mysqli_fetch_assoc($result)){
						echo '<tr>';
						echo '<td>'.$row['update_timestamp'].'<br>'.$row['course'].' - '.$row['event_name'];
						$query2 = "SELECT (SELECT username FROM user_table where user_id=uid) as user_name, user_id from user_courses where active=1 and course_id = '{$row['course']}' ";
						//echo $query2;
						if ($result2 = mysqli_query($link, $query2)){
							while ($row2 = mysqli_fetch_assoc($result2)){
								echo '<br><a href="'.$app_path.'settings/'.$row2['user_id'].'">'.$row2['user_name'].'</a>; ';
							}
						}
						echo '</td>';
						echo '<td>'.$row['count(course)'].'</td>';
						$query2 = "SELECT count(course_name) as stat1 from course_search_history where course_name = '{$row['course']} - {$row['event_name']}' ";
						//echo $query2;
						if ($result2 = mysqli_query($link, $query2)){
							while ($row2 = mysqli_fetch_assoc($result2)){
								echo '<td>'.$row2['stat1'].'</td>';
							}
						}
						//echo '<td></td>';
						echo '</tr>';
					}
					echo '</table></div></div>';
				}

				echo '<div class="row">';
				echo '<div class="col-md-12">';
				echo '<h2>Most popular course today</h2> ';
				//+ INTERVAL 2 day
				$query = "SELECT course, event_name, (SELECT count(course_id) from user_courses where active=1 and course=course_id) as stat1 from timetable where date(start_time)=curdate()  group by course ORDER BY `stat1` DESC limit 10";
				//echo $query;

				if ($result = mysqli_query($link, $query)){
					echo '<table class="table table-striped">';
					echo '<tr>';
					echo '<th>Course</th>';
					//echo '<th>location</th>';
					echo '<th>Users</th>';
					echo '</tr>';

					while ($row = mysqli_fetch_assoc($result)){
						echo '<tr>';
						echo '<td>'.$row['course'].' - '.$row['event_name'].'<br>';

						$query2 = "SELECT (SELECT username FROM user_table where user_id=uid) as user_name, user_id from user_courses where active=1 and course_id = '{$row['course']}' order by added_on desc ";
						//echo $query2;

						if ($result2 = mysqli_query($link, $query2)){
							while ($row2 = mysqli_fetch_assoc($result2)){
								echo '<a href="'.$app_path.'settings/'.$row2['user_id'].'">'.$row2['user_name'].'</a>; ';
							}
						}
						echo '</td>';
						//echo '<td><a href="http://coursesearch.esy.es/index.php?page=room_schedule&room_name='.$row['event_location'].'"> '.$row['event_location'].'</a> </td>';
						echo '<td>'.$row['stat1'].'</td>';
						echo '</tr>';
					}
					echo '</table></div>';
				}
			?>
			</div>
		</div>

    <div role="tabpanel" class="tab-pane" id="statistics">
			<div class="row">
				<h2 id="stats2">Stats</h2>
				<div class="col-md-6">
					<div id="draw3"></div>
				</div>
				<div class="col-md-6">
					<div id="draw4"></div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div id="draw1"></div>
				</div>
				<div class="col-md-6">
					<div id="draw2"></div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div id="draw5"></div>
				</div>
				<div class="col-md-6">
					<div id="draw6"></div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div id="draw7"></div>
				</div>
				<div class="col-md-6">
					<div id="draw8"></div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php

	if ($_SESSION['userID']==29 && isset($_GET['user_id'])){

		$user_id = htmlspecialchars($_GET['user_id']);

		$user_id = $_GET['user_id'];

	  $query = "SELECT uid, username, registered_on from user_table where uid=$user_id";


	  if ($result = mysqli_query($link, $query)){
	    while ($row = mysqli_fetch_assoc($result)){

	      echo '<h2>User: '.$row['username'].'</h2>';

	      echo '<a href="'.$app_path.'settings#users"> Back to statistics </a> <br>';

	      echo 'Registered on: '.$row['registered_on'].' (';

	      $now = time(); // or your date as well
	      $your_date = strtotime($row['registered_on']);
	      $datediff = $now - $your_date;

	      echo floor($datediff / (60 * 60 * 24)).' days ago)<br><br>';

	    }
	  }




	  $query = "SELECT user_id, user_name, ip_address as stat1, login_time from user_login_log where user_id='{$user_id}'order by login_time desc limit 5";
	  if ($result = mysqli_query($link, $query)){

	    echo '<div class="col-md-6"><h2 id="users">Latest logins</h2>';
	    echo '<table class="table table-striped">';
	    echo '<tr>';
	    //echo '<th>Course</th>';

	    echo '<th>Login time</th>';
	    echo '<th>IP</th>';
	    echo '</tr>';

	    while ($row = mysqli_fetch_assoc($result)){
	      echo '<tr>';
	    //  echo '<td>'.$row['course_id'].'</td>';
	      //echo '<td><a href="statistics_user_courses.php?admin_pass=fslkfdskl234j2kljsdfskljsdf2dsc24fd2vc2x&user_id='.$row['user_id'].'">'.$row['user_name'].' </a></td>';
	      echo '<td>'.$row['login_time'].'</td>';
	      echo '<td><a href="http://whatismyipaddress.com/ip/'.$row['stat1'].'" target="_blank">'.$row['stat1'].'</a></td>';

	      echo '</tr>';

	    }
	    echo '</table></div>';

	  }

	  $query = "SELECT user_id, (select username from user_table where uid='{$user_id}') as user_name, access_date from url_cal_access where user_id='{$user_id}' order by access_date desc limit 5";
	  //echo $query;
	  if ($result = mysqli_query($link, $query)){

	    echo '<div class="col-md-6"><h2 id="users">Latest URL - calendars</h2>';
	    echo '<table class="table table-striped">';
	    echo '<tr>';
	    //echo '<th>Course</th>';
	    echo '<th>Access time</th>';
	    echo '</tr>';

	    while ($row = mysqli_fetch_assoc($result)){
	      echo '<tr>';
	    //  echo '<td>'.$row['course_id'].'</td>';

	      echo '<td>'.$row['access_date'].'</td>';
	    //  echo '<td><a href="http://whatismyipaddress.com/ip/'.$row['stat1'].'" target="_blank">'.$row['stat1'].'</a></td>';

	      echo '</tr>';
	    }
	    echo '</table></div>';

	  }


	  $query = "SELECT course, event_name, event_type, event_location, DATE_FORMAT(start_time,'%d.%m.%Y') as start_date, DATE_FORMAT(start_time,'%H:%i') as start, DATE_FORMAT(end_time,'%H:%i') as end_t FROM timetable WHERE start_time>NOW() and  course in (select course_id from user_courses where user_id='{$user_id}') and start_time order by start_time asc limit 5";

	  //echo $query;
	  echo '<h2>Upcoming events</h2>';
	  echo '<table class="table table-striped">';
	  echo '<tr>';
	  //echo '<th>username</th>';
	  echo '<th>Event</th>';
	  echo '<th>Location</th>';
	  echo '<th>Other users</th>';

	  echo '</tr>';

	  if ($result = mysqli_query($link, $query)){
	    while ($row = mysqli_fetch_assoc($result)){
	      echo '<tr>';
	      //echo '<td>'.$row['username'].'</td>';
	      echo '<td>'.$row['start'].' - '.$row['end_t'].' ('.$row['start_date'].')<br>'.$row['course'].' - '.$row['event_name'].' ('.$row['event_type'].')</td>';
	      echo '<td>'.$row['event_location'].'</td>';
	      $query2 = "SELECT count(course_id) as stat1 from user_courses where course_id='{$row['course']}'";
	      //echo $query2;
	      if ($result2 = mysqli_query($link, $query2)){
	        while ($row2 = mysqli_fetch_assoc($result2)){
	          echo '<td>'.$row2['stat1'].'</td>';
	        }
	      }
	      echo '</tr>';
	    }
	  }
	  echo '</table>';

	  $query = "SELECT course_id, (select event_name from timetable where course_id=course limit 1) as event_name, (select username from user_table where user_id=uid) as username, added_on, active FROM `user_courses` where user_id=$user_id group by username, course_id order by active desc, added_on desc";

	  //echo $query;

	  echo '<table class="table table-striped">';
	  echo '<tr>';
	  //echo '<th>username</th>';
	  echo '<th>course</th>';
	  echo '<th>added</th>';
	  echo '<th>active</th>';

	  echo '</tr>';

	  if ($result = mysqli_query($link, $query)){
	    while ($row = mysqli_fetch_assoc($result)){
	      echo '<tr>';
	      //echo '<td>'.$row['username'].'</td>';
	      echo '<td>'.$row['course_id'];
	      echo ' - '.$row['event_name'].'</td>';
	      echo '<td>'.$row['added_on'].'</td>';
	      echo '<td align="right">'.$row['active'].'</td>';

	      echo '</tr>';
	    }
	  }
	  echo '</table>';


	}

?>

<script>

	$(document).ready(function() {

	google.charts.load('current', {'packages':['corechart']});

	google.charts.setOnLoadCallback(draw1);
	google.charts.setOnLoadCallback(draw2);
	google.charts.setOnLoadCallback(draw3);
	google.charts.setOnLoadCallback(draw4);
	google.charts.setOnLoadCallback(draw5);
	google.charts.setOnLoadCallback(draw6);
	google.charts.setOnLoadCallback(draw7);
	google.charts.setOnLoadCallback(draw8);


	function draw1() {

		// Create the data table for Sarah's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'CourseType');
		data.addColumn('number', 'Amount');
		data.addRows([

		<?php

		$query = "SELECT course_name as course FROM `course_search_history` where date(time_of_search) = CURDATE() order by course_name asc";
		//echo $query;
		$course_type_array = array();
		$course = new course_type();
		if ($result = mysqli_query($link, $query)){
			while ($row = mysqli_fetch_assoc($result)){
				$type = $course->return_type($row['course']);
				//echo $type;
				if (array_key_exists($type, $course_type_array)){
					$course_type_array[$type] += 1;
				}else{
					$course_type_array[$type] = 1;
				}
			}
		}

		arsort($course_type_array);

		foreach ($course_type_array as $v => $value){
			echo '["'.$v.'", '.$value.'],';
		}

		?>
		]);

		// Set options for Sarah's pie chart.
		var options = {title:'Coursetypes Today',
									 height:300};

		// Instantiate and draw the chart for Sarah's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('draw1'));
		chart.draw(data, options);
	}

	function draw2() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Hour');
		data.addColumn('number', 'Visitors');
		data.addRows([
			<?php
			$query = "SELECT HOUR(time_of_search) as s1, count(*) as s2 FROM `course_search_history` where date(time_of_search) = curdate() group by hour(time_of_search) ORDER BY HOUR(time_of_search) ASC";
			if ($result = mysqli_query($link, $query)){

				while ($row = mysqli_fetch_assoc($result)){

					echo '['.$row['s1'].', '.$row['s2'].'],';

				}
			}
			?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'Visitors by hour Today',
									 //width:400,
									 bar: {groupWidth: "5%"},
									 legend: { position: "none" },
									 height:300};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.ColumnChart(document.getElementById('draw2'));
		chart.draw(data, options);
	}

	function draw3() {

		// Create the data table for Sarah's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'CourseType');
		data.addColumn('number', 'Amount');
		data.addRows([

		<?php

		$query = "SELECT course_name as course FROM `course_search_history` order by course_name asc";
		//echo $query;
		$course_type_array = array();
		$course = new course_type();
		if ($result = mysqli_query($link, $query)){
			while ($row = mysqli_fetch_assoc($result)){
				$type = $course->return_type($row['course']);
				//echo $type;
				if (array_key_exists($type, $course_type_array)){
					$course_type_array[$type] += 1;
				}else{
					$course_type_array[$type] = 1;
				}
			}
		}
		arsort($course_type_array);

		foreach ($course_type_array as $v => $value){
			echo '["'.$v.'", '.$value.'],';
		}

		?>
		]);

		// Set options for Sarah's pie chart.
		var options = {title:'Coursetypes',
									 height:300};

		// Instantiate and draw the chart for Sarah's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('draw3'));
		chart.draw(data, options);
	}

	function draw4() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Hour');
		data.addColumn('number', 'Visitors');
		data.addRows([
			<?php
			$query = "SELECT HOUR(time_of_search) as s1, count(*) as s2 FROM `course_search_history` group by hour(time_of_search) ORDER BY HOUR(time_of_search) ASC";
			if ($result = mysqli_query($link, $query)){

				while ($row = mysqli_fetch_assoc($result)){

					echo '['.$row['s1'].', '.$row['s2'].'],';

				}
			}
			?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'Visitors by hour',
									 //width:400,
									 height:300};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.ColumnChart(document.getElementById('draw4'));
		chart.draw(data, options);
	}

	function draw5() {

		// Create the data table for Sarah's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Page');
		data.addColumn('number', 'Clicks');
		data.addRows([

		<?php

		$query = "SELECT visited_page, count(*) FROM `visitors` group by visited_page order by count(*) desc";
		//echo $query;

		if ($result = mysqli_query($link, $query)){
			while ($row = mysqli_fetch_assoc($result)){

				echo '["'.$row['visited_page'].'", '.$row['count(*)'].'],';


			}
		}


		?>
		]);

		// Set options for Sarah's pie chart.
		var options = {title:'Pages',
									 height:300};

		// Instantiate and draw the chart for Sarah's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('draw5'));
		chart.draw(data, options);
	}

	function draw6() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Hour');
		data.addColumn('number', 'PageClickers');
		data.addRows([
			<?php
			$query = "SELECT HOUR(visiting_time) as s1, count(*) as s2 FROM `visitors` group by hour(visiting_time) ORDER BY HOUR(visiting_time) ASC";
			if ($result = mysqli_query($link, $query)){

				while ($row = mysqli_fetch_assoc($result)){

					echo '['.$row['s1'].', '.$row['s2'].'],';

				}
			}
			?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'Pageclickers by hour Total',
									 //width:400,
									 height:300};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.ColumnChart(document.getElementById('draw6'));
		chart.draw(data, options);
	}

	function draw7() {

		// Create the data table for Sarah's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Page');
		data.addColumn('number', 'Clicks');
		data.addRows([

		<?php
		$query = "SELECT visited_page, count(*) FROM `visitors` where date(visiting_time)=curdate() group by visited_page order by count(*) desc";
		//echo $query;
		if ($result = mysqli_query($link, $query)){
			while ($row = mysqli_fetch_assoc($result)){
				echo '["'.$row['visited_page'].'", '.$row['count(*)'].'],';
			}
		}
		?>
		]);

		// Set options for Sarah's pie chart.
		var options = {title:'Pages clicked today',
									 height:300};

		// Instantiate and draw the chart for Sarah's pizza.
		var chart = new google.visualization.PieChart(document.getElementById('draw7'));
		chart.draw(data, options);
	}

	function draw8() {

		// Create the data table for Anthony's pizza.
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Hour');
		data.addColumn('number', 'PageClickers');
		data.addRows([
			<?php
			$query = "SELECT HOUR(visiting_time) as s1, count(*) as s2 FROM `visitors` where date(visiting_time) = curdate() group by hour(visiting_time) ORDER BY HOUR(visiting_time) ASC";
			if ($result = mysqli_query($link, $query)){

				while ($row = mysqli_fetch_assoc($result)){

					echo '['.$row['s1'].', '.$row['s2'].'],';

				}
			}
			?>
		]);

		// Set options for Anthony's pie chart.
		var options = {title:'Pageclickers by hour Today',
									 //width:400,
									 height:300};

		// Instantiate and draw the chart for Anthony's pizza.
		var chart = new google.visualization.ColumnChart(document.getElementById('draw8'));
		chart.draw(data, options);
	}

	});

</script>




<?php
}
	?>



	</div>
</div>
