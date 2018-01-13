<?php

$cal_token='';
if (isset($_GET['cal_token'])){
  $cal_token=$_GET['cal_token'];
}else{
  exit();
}

include("includes/connection.php");

header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=UNI_COURSES.ICS');
echo 'BEGIN:VCALENDAR';
echo "\r\n";
echo 'PRODID:-//CourseSearch//CourseEvents//FI';
echo "\r\n";
echo 'VERSION:2.0';
echo "\r\n";
echo 'X-WR-CALNAME:UNI_COURSES';
echo "\r\n";
echo 'X-WR-TIMEZONE:Europe/Helsinki';
echo "\r\n";
echo "METHOD:PUBLISH";
echo "\r\n";

date_default_timezone_set('Europe/Helsinki');

$date = new DateTime();
$access_date=$date->format("Y-m-d H:i:s");



$query = "INSERT INTO url_cal_access(user_id, access_date) SELECT user_id, '{$access_date}' from calendar_tokens where cal_token='{$cal_token}'";
//echo $query;

mysqli_query($link, $query);



$setti = array();

$query = "SELECT course, event_name FROM user_courses, timetable where user_id=(select user_id from calendar_tokens where cal_token='{$cal_token}') and timetable.course=user_courses.course_id group by course";

 if ($result = mysqli_query($link, $query)){
  while ($row = mysqli_fetch_assoc($result)){

   array_push($setti, $row['course']);
//$_SESSION['courses'][$row['course']]=$row['course'];
  }
}else {
  exit();
}


$query = 'SELECT concat(event_name, " ", course) as title, DATE_FORMAT(start_time,"%Y%m%dT%H%i%S") as start, DATE_FORMAT(end_time,"%Y%m%dT%H%i%S") as end, event_description, event_location, event_type FROM timetable where course IN (';

foreach($setti as $t_id) {
  $query.="'".$t_id."',";
}
$query=substr($query, 0, -1).")";

//$query=substr($query, 0, -1).") and event_type <> 'EXAM'";
//echo $query;

if ($result = mysqli_query($link, $query)){
	while ($row = mysqli_fetch_assoc($result)){
		echo 'BEGIN:VEVENT';
		echo "\r\n";
		echo 'DTSTART:'.$row['start'];
		echo "\r\n";
		echo 'DTEND:'.$row['end'];
		echo "\r\n";

    // $query2 = "SELECT latitude, longitude FROM room_location where room_name='{$row['event_location']}' limit 1";
    //
    // if ($result2 = mysqli_query($link, $query2)){
    // 	while ($row2 = mysqli_fetch_assoc($result2)){
    //     echo 'GEO:'.$row2["latitude"].';'.$row2["longitude"];
    //   }
    // }
    echo "\r\n";
		echo 'LOCATION:'.$row['event_location'];
		echo "\r\n";
		echo 'DESCRIPTION:'.$row['event_description'];
		echo "\r\n";
		echo 'SUMMARY:'.$row['title'].' ('.$row['event_type'].')';
		echo "\r\n";
		echo 'END:VEVENT';
		echo "\r\n";
	}
}

echo 'END:VCALENDAR';
?>
