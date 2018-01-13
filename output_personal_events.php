<?php
session_start();
require("includes/connection.php");
?>
BEGIN:VCALENDAR
PRODID:-//CourseSearch//PERSONAL//FI
VERSION:2.0
X-WR-CALNAME:PERSONAL
METHOD:PUBLISH
<?php
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=COURSESEARCH_PERSONAL_EVENTS.ICS');

$user_id = $_SESSION['userID'];
$query = "SELECT event_name as title, event_description as description, DATE_FORMAT(start_time, '%Y%m%dT%H%i%S') as start_time, DATE_FORMAT(end_time, '%Y%m%dT%H%i%S') as end_time, location FROM user_events where user_id = {$user_id}";

if ($result = mysqli_query($link, $query)){
	while ($row = mysqli_fetch_assoc($result)){
		echo 'BEGIN:VEVENT';
		echo "\n";
		echo 'DTSTART:'.$row['start_time'];
		echo "\n";
		echo 'DTEND:'.$row['end_time'];
		echo "\n";
		echo 'UID:'.uniqid();
		echo "\n";
		echo 'LOCATION:'.$row['location'];
		echo "\n";
		echo 'DESCRIPTION:'.$row['description'];
		echo "\n";
		echo 'SUMMARY:'.$row['title'];
		echo "\n";
		echo 'END:VEVENT';
		echo "\n";
	}
}
?>
END:VCALENDAR
