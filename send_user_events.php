<?php



if (time() >= strtotime("01:00:00") && time() <= strtotime("04:00:00")) {
//if (time() >= strtotime("12:00:00") && time() <= strtotime("16:00:00")) {

	echo "in range ".date("h:i:s");
}else{
	echo "not in range ".date("h:i:s");
  header("location: index.php");
  exit();
}


if(isset($_GET['key'])) {
  if ($_GET['key']=="veryLongPassword24234324ForHippies"){
      echo "all is good\n<br>";
  }else {
      echo "\nexit\n";
      header("location: index.php");
      exit();
  }
}else{
  echo "\nexit\n";
  header("location: index.php");
  exit();
}

//exit();
//header("location: index.php");
include("includes/connection.php");

  //get data for all users:
  $query = "SELECT uid, username, user_email, access_lvl, send_reminders FROM user_table";
  if ($result_1 = mysqli_query($link, $query)){
    while ($row_1 = mysqli_fetch_assoc($result_1)){
      $userName = $row_1['username'];
      $userID = $row_1["uid"];
      $acc_lvl = $row_1["access_lvl"];
      $email = $row_1["user_email"];
      $send = $row_1["send_reminders"];

      //ECHO "<BR>######################";
      //echo $email;
      //ECHO "<BR>########################";
      //echo $send;
      //ECHO "<BR>";

      if ($email <> "" && $send == "TRUE"){
        //echo $email;
        //echo '<br>';
        $user_course_list = array();
        $sql_query = "select course_id from user_courses where user_id={$userID}";

        if ($result_2 = mysqli_query($link, $sql_query)){
          while ($row_2 = mysqli_fetch_assoc($result_2)){
              array_push($user_course_list, $row_2['course_id']);
          }
        }
        //print_r($user_course_list);
        //echo "<br>";

        //Output course events with items in user course list:
        $sql_query_2 = "SELECT event_type, event_name as course_name, event_location, event_description as description, date_format(start_time, '%k:%i') as date_1,  date_format(end_time, '%k:%i') as date_2, course FROM timetable where course IN (";

        foreach($user_course_list as $t_id => $value) {
          $sql_query_2.="'".$user_course_list[$t_id]."',";
        }

        $sql_query_2=substr($sql_query_2, 0, -1).")";
        $sql_query_2 .= ' and end_time >= CURDATE() and start_time <= CURDATE() + INTERVAL 1 DAY order by start_time asc ';

        //Create message to send to user email:

        $message = "<h3>Hi, {$userName}!</h3>";
        $message .= '<p>You have following events:</p>';
        $event_count_today = 0;

        $message_today = "<h3>EVENTS FOR TODAY:</h3><HR>";

        if ($result_3 = mysqli_query($link, $sql_query_2)){
          while ($row_3 = mysqli_fetch_assoc($result_3)){
            $message_today .= "<i>".$row_3['date_1']." - ".$row_3['date_2']." </i> - ";

            $message_today .= "<b>".$row_3['course_name']." </b> <i> (".$row_3['event_location'].") </i> - ";

            if ($row_3['event_type']=='EXAM'){
              $message_today .= '<font color="red">'.$row_3['event_type']."</font><br>";

            }else {
              $message_today .= $row_3['event_type']."<br>";

            }



            if ($row_3['description']<>""){
              $message_today .= "".$row_3['description']."<br> ";
            }


            //$message_today .= '<form method=get action="https://weboodi.lut.fi/oodi/ilmsuor.jsp" target="_blank"><input type=hidden value="'.substr($row_3["course"], 0, 9).'" name=hakuehto size=20><input class="btn btn-default" type=submit value="weboodi"></form></p>';
            $event_count_today += 1;
          }
        }

        $sql_query_2 = "SELECT event_name, date_format(start_time, '%k:%i') as date_1,  date_format(end_time, '%k:%i') as date_2, event_description, location FROM user_events where user_id={$userID} ";
        $sql_query_2 .= ' and end_time >= curdate() and start_time <= CURDATE() + INTERVAL 1 DAY  order by start_time asc ';

        if ($result_3 = mysqli_query($link, $sql_query_2)){
          while ($row_3 = mysqli_fetch_assoc($result_3)){
            $message_today .= "<i>".$row_3['date_1']." - ".$row_3['date_2']." </i> - ";
            $message_today .= "<b>".$row_3['event_name']." </b> <i> (".$row_3['location'].") </i> - PERSONAL<br>";

            if ($row_3['event_description']<>""){
              $message_today .= "".$row_3['event_description']."<br> ";
            }

            $event_count_today += 1;
          }
        }


        $event_count_tomorrow = 0;
        $message_tomorrow = "<h3>EVENTS FOR TOMORROW:</h3><HR>";

        $sql_query_2 = "SELECT event_type, event_name as course_name, event_location, event_description as description, date_format(start_time, '%k:%i') as date_1,  date_format(end_time, '%k:%i') as date_2, course FROM timetable where course IN (";

        foreach($user_course_list as $t_id => $value) {
          $sql_query_2.="'".$user_course_list[$t_id]."',";
        }

        $sql_query_2=substr($sql_query_2, 0, -1).")";
        $sql_query_2 .= ' and end_time >= curdate() + INTERVAL 1 DAY and start_time <= CURDATE() + INTERVAL 2 DAY  order by start_time asc ';

        if ($result_3 = mysqli_query($link, $sql_query_2)){
          while ($row_3 = mysqli_fetch_assoc($result_3)){
            $message_tomorrow .= "<i>".$row_3['date_1']." - ".$row_3['date_2']." </i> - ";


            if ($row_3['event_type']=='EXAM'){
              $message_tomorrow .= "<b>".$row_3['course_name']." </b> <i> (".$row_3['event_location'].') </i> - <font color="red">'.$row_3['event_type']."</font><br>";

            }else {
              $message_tomorrow .= "<b>".$row_3['course_name']." </b> <i> (".$row_3['event_location'].") </i> - ".$row_3['event_type']."<br>";

            }

            //$message_tomorrow .= "<b>".$row_3['course_name']." </b> <i> (".$row_3['event_location'].") </i> - ".$row_3['event_type']."<br>";

            if ($row_3['description']<>""){
              $message_tomorrow .= "".$row_3['description']."<br> ";
            }

            //$message_future .= '<p><form method=get action="https://weboodi.lut.fi/oodi/ilmsuor.jsp" target="main"><input type=hidden value="'.substr($row_3["course"], 0, 9).'" name=hakuehto size=20><input class="btn btn-default" type=submit value="Check"></form></p>';
            $event_count_tomorrow += 1;
          }
        }

        $sql_query_2 = "SELECT event_name, date_format(start_time, '%k:%i') as date_1,  date_format(end_time, '%k:%i') as date_2, event_description, location FROM user_events where user_id={$userID} ";
        $sql_query_2 .= ' and end_time >= curdate() + INTERVAL 1 DAY and start_time <= CURDATE() + INTERVAL 2 DAY  order by start_time asc ';

        if ($result_3 = mysqli_query($link, $sql_query_2)){
          while ($row_3 = mysqli_fetch_assoc($result_3)){
            $message_tomorrow .= "<i>".$row_3['date_1']." - ".$row_3['date_2']." </i> - ";
            $message_tomorrow .= "<b>".$row_3['event_name']." </b> <i> (".$row_3['location'].") </i> - PERSONAL<br>";

            if ($row_3['event_description']<>""){
              $message_tomorrow .= "".$row_3['event_description']."<br> ";
            }

            $event_count_tomorrow += 1;
          }
        }





        $event_count_future = 0;
        $message_future = "<h3>EXAMS: (In 7 - 9 days)</h3><HR>";

        $sql_query_2 = "SELECT event_type, course, event_name as course_name, event_location, event_description as description, date_format(start_time, '%d.%m.%Y at %k:%i') as date_1,  date_format(end_time, '%k:%i') as date_2, course FROM timetable where course IN (";

        foreach($user_course_list as $t_id => $value) {
          $sql_query_2.="'".$user_course_list[$t_id]."',";
        }

        $sql_query_2=substr($sql_query_2, 0, -1).")";
        $sql_query_2 .= ' and end_time >= curdate() + INTERVAL 7 DAY and start_time <= CURDATE() + INTERVAL 9 DAY and event_type="EXAM" order by start_time asc ';

        if ($result_3 = mysqli_query($link, $sql_query_2)){
          while ($row_3 = mysqli_fetch_assoc($result_3)){
            $message_future .= "<i>".$row_3['date_1']."</i> - ";
            $message_future .= "<b>".$row_3['course_name']." (".$row_3['course'].") </b><br>";
            //$message_future .= "<p>".$row_3['description']."</p>";
            //$message_future .= '<p><form method=get action="https://weboodi.lut.fi/oodi/ilmsuor.jsp" target="main"><input type=hidden value="'.substr($row_3["course"], 0, 9).'" name=hakuehto size=20><input class="btn btn-default" type=submit value="Check"></form></p>';
            $event_count_future += 1;
          }
        }

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <coursesearch@coursesearch.esy.es>' . "\r\n";

        if ($event_count_today > 0){
          $message .= $message_today;
        }

        if ($event_count_tomorrow > 0){
          $message .= $message_tomorrow;
        }

        if ($event_count_future > 0){
          $message .= $message_future;
        }




        $message .= "<br>";
        $message .= '<p>In case these events are inconsistent with UNI-lut, <br>could you please contact <a href="http://coursesearch.esy.es/index.php?page=about" target="_blank">CourseSearch</a> by answering this email.</p>';
        $message .= "<p>Best regards</p>";
        $message .= "<p>- CourseSearch</p>";
        $message .= '<p><i>This is automated message, which displays your selected events. <br>To cancel emails, go to <a href="http://coursesearch.esy.es/index.php?page=login" target="_blank">CourseSearch</a> and change settings</p>';
        $message .= "<p>Emails are only sent if you have events available.</i></p>";

        if ($event_count_today < 1 && $event_count_future < 1 && $event_count_tomorrow < 1){
          //echo 'no events!<br>';
        }else{

          $head_tags = '<html><head>';
          $head_tags .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';
          $head_tags .= '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';
          $head_tags .= '';
          $head_tags .= '</head>';

          $message = $head_tags.'<div class="containter"><div class="col-md-12">'.$message.'</div></div></html>';



          echo '###################### START #######################<br>';
          echo $email.'<br>';

          echo $message."\r\n\r\n";
          echo '####################### END ########################<br>';
          mail($email, 'CourseSearch events', $message, $headers);
        }

      }else {
        echo $email.' - nope <br>';
        //Dont do anything as email is null
      }
    }
  }

//header("Location: index.php");
?>
