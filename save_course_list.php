<?php

session_start();
include_once("includes/connection.php");
include_once("includes/functions.php");

//Check if cart has courses:
if(isset($_SESSION['courses'])){
  if(isset($_SESSION['userID'])){

    $userID = mysqli_real_escape_string($link, $_SESSION['userID']);
    date_default_timezone_set('Europe/Helsinki');

    $date = new DateTime();
    $new_time=$date->format("Y-m-d H:i:s");

    //Set all user current courses to inactive
    $sql = "UPDATE user_courses SET active=0 WHERE user_id={$userID}" or die(mysql_error());
    $query=mysqli_query($link, $sql);

    //Loop through cart items and save or update them to user courselist
    foreach($_SESSION['courses'] as $id => $value){
      $course_id= mysqli_real_escape_string($link, $id);

      $sql = "SELECT * FROM user_courses WHERE user_id={$userID} AND course_id='{$course_id}'" or die(mysql_error());
      //Echo $sql;
      $query=mysqli_query($link, $sql);
      if (mysqli_num_rows(mysqli_query($link, $sql))>0){ //update event to active
        $sql2 = "UPDATE user_courses SET active=1 WHERE user_id={$userID} AND course_id='{$course_id}'" or die(mysql_error());
        //ECHO $sql2;
        $query2=mysqli_query($link, $sql2);
      }else{
        $sql2 = "INSERT INTO user_courses (course_id, user_id, added_on, active) VALUES ('{$course_id}', {$userID}, '{$new_time}', 1)" or die(mysql_error());
        //echo $sql2;
        $query2=mysqli_query($link, $sql2);
      }
    }
  }
}



header("location: {$_SESSION['last_page']}");

?>
