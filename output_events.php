<?php
session_start();
require("includes/connection.php");
?>
BEGIN:VCALENDAR
PRODID:-//CourseSearch//CourseEvents//FI
VERSION:2.0
X-WR-CALNAME:COURSES
METHOD:PUBLISH
<?php
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=COURSESEARCH_COURSES.ICS');

$query = 'SELECT concat(course, " ", event_name) as title, DATE_FORMAT(start_time,"%Y%m%dT%H%i%S") as start, DATE_FORMAT(end_time,"%Y%m%dT%H%i%S") as end, event_description, event_location FROM timetable where course IN (';

foreach($_SESSION['courses'] as $id => $value){
	$query.="'".$id."',";
}




$query=substr($query, 0, -1).") and event_type <> 'EXAM'";

if ($result = mysqli_query($link, $query)){
	while ($row = mysqli_fetch_assoc($result)){
		echo 'BEGIN:VEVENT';
		echo "\n";
		echo 'DTSTART:'.$row['start'];
		echo "\n";
		echo 'DTEND:'.$row['end'];
		echo "\n";
		echo 'UID:'.uniqid();
		echo "\n";
		echo 'LOCATION:'.$row['event_location'];
		echo "\n";
		echo 'DESCRIPTION:'.$row['event_description'];
		echo "\n";
		echo 'SUMMARY:'.$row['title'];
		echo "\n";
		echo 'END:VEVENT';
		echo "\n";
	}
}
?>
END:VCALENDAR
