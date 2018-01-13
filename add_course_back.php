<?php


session_start();


if(isset($_GET['course'])){


  $course_setti = explode(" - ", $_GET['course']);
  $course_id = mysqli_real_escape_string($link, $course_setti[0]);
  $course_name = mysqli_real_escape_string($link, $_GET['AddBack']);

  $query = "SELECT * FROM timetable where course='{$course_id}'";
  course_search($_POST['AddBack']);

  if (mysqli_num_rows(mysqli_query($link, $query))>0){

    save_course_list();

    $_SESSION['courses'][$course_id]=$course_name;
    asort($_SESSION['courses']);

    header("location: settings");
  }

}

?>
