<?php

include_once("includes/connection.php");
include_once("includes/functions.php");

session_start();
//store_visitor_data();

$error_mes = "";

if (isset($_SESSION['last_page'])){

}else{
  $_SESSION['last_page'] = "calendar";
}


if (isset($_POST["userName"]) && isset($_POST["passWord"])) {
  $result_from_login = user_login($_POST["userName"], $_POST["passWord"]);
  if ($result_from_login===1){
		$_page = "calendar";
  }elseif($result_from_login===0) {
    $error_mes = '<div class="alert alert-danger" role="alert">Login problem! <a href="reset_password">Forgot your password?</a></div>';
  }else {
    $error_mes = $result_from_login;
  }
}

if (isset($_POST["start_time"]) && isset($_POST["end_time"]) && isset($_POST["event_description"]) && isset($_POST["event_name"]) && isset($_POST["event_location"]) && isset($_POST["event_update"])) {

  if(isset($_SESSION['userID'])){
    edit_personal_event($_POST["start_time"], $_POST["end_time"], $_POST["event_description"], $_POST["event_name"], $_POST["event_location"], $_POST['event_update']);
    //header("location: index.php?page=frontpage");
    //  echo $_POST['event_update'];
  }else{
    header("location: login");
  }
}

if (isset($_POST["start_time"]) && isset($_POST["end_time"]) && isset($_POST["event_description"]) && isset($_POST["event_name"]) && isset($_POST["event_location"]) && isset($_POST["event_id"])==false && isset($_POST["event_update"])==false) {
  //echo $_POST['start_time'];
  if(isset($_SESSION['userID'])){
    add_new_event($_POST["start_time"], $_POST["end_time"], $_POST["event_description"], $_POST["event_name"], $_POST["event_location"]);
    header("location: calendar");
  }else{
    header("location: login");
  }
}

if (isset($_POST["Save"]) && isset($_POST["start_time"]) && isset($_POST["end_time"]) && isset($_POST["event_description"]) && isset($_POST["event_name"]) && isset($_POST["event_location"]) && isset($_POST["event_id"])) {
  //echo $_POST['event_update'];
  if(isset($_SESSION['userID'])){
    edit_personal_event($_POST["start_time"], $_POST["end_time"], $_POST["event_description"], $_POST["event_name"], $_POST["event_location"], $_POST['event_id']);
    //
    $_SESSION['def_date1'] = $_POST['start_time'];
    header("location: calendar");
    //echo $_SESSION['def_date1'];
  }else{
    header("location: login");
  }
}

if (isset($_POST["Delete"]) && isset($_POST["start_time"]) && isset($_POST["end_time"]) && isset($_POST["event_description"]) && isset($_POST["event_name"]) && isset($_POST["event_location"]) && isset($_POST["event_id"])) {
  if(isset($_SESSION['userID'])){
    //echo $_POST['event_id'];
    remove_personal_event($_POST['event_id']);
    header("location: calendar");
  }else{
    header("location: login");
  }
}

if (isset($_POST["comment_id"])) {
  if(isset($_SESSION['userID'])){
    $comment_id = htmlspecialchars($_POST['comment_id']);
    remove_comment($comment_id);

    header("location: {$_SESSION['last_page']}");

  }else{
    header("location: login");
  }
}

if (isset($_POST["report_comment_id"])) {
    report_comment($_POST['report_comment_id']);
    if ($_GET['page']=="comments"){
      header("location: comments");
    }elseif ($_GET['page']=="calendar"){
      header("location: calendar");
    }else {
      header("location: calendar");
    }
}

if (isset($_POST["new_event_comment"]) && isset($_POST["course"]) && isset($_POST["event_name"]) && isset($_POST["start_time"]) && isset($_POST["event_comment"])) {
  if(isset($_SESSION['userID'])){
    echo $_POST['event_comment'];
    echo $_POST['course'];
    echo $_POST['event_name'];
    echo $_POST['start_time'];

    add_new_comment($_POST['course'], $_POST['event_name'], $_POST['start_time'], $_POST['event_comment']);

    header("location: {$_SESSION['last_page']}");

  }else{
    header("location: login");
  }
}


if(isset($_POST['remove_course_from_session']) && isset($_POST['course_id'])){

  //echo $_POST['course_id'];
  //echo str_replace('_',' ',$_POST['course_id']);

  if(isset($_SESSION['courses'][str_replace('_',' ',$_POST['course_id'])])){
    unset($_SESSION['courses'][str_replace('_',' ',$_POST['course_id'])]);
    //unset($_SESSION['courses']);
  }


}




if(isset($_POST['search'])){

  // echo $_POST['search']."_<br>";
  $course_setti = explode(" - ", $_POST['search']);
  $course_id = mysqli_real_escape_string($link, $course_setti[0]);
  $course_name = mysqli_real_escape_string($link, $_POST['search']);
  //$course=substr($_POST['search'], 0, 9);

  // echo $course_setti[0];
  // echo "_<br>";
  // echo $course_setti[1];
  // echo "_<br>";

  $query = "SELECT * FROM timetable where course='{$course_id}'";

  course_search($_POST['search']);

  if (mysqli_num_rows(mysqli_query($link, $query))>0){
    $_SESSION['courses'][$course_id]=$course_name;
    asort($_SESSION['courses']);
    // print_r(json_encode($_SESSION['courses']));
    header("location: calendar");
  }else{
    // echo 'no course';
  }

}



if(isset($_POST['search_room'])){

  $room_name = $_POST['search_room'];
  echo $room_name;
  $room_name = str_replace('+','%2B',$room_name);
  header("location: ".$app_path."room_schedule/".$room_name);
}






?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="CourseSearch is designed to reduce time used searching courses and collects all the necessary course data in one place. Course data is collected from UNI - portal, parsed and brought to user. Unfortunately data in UNI needs to be precise, which can in some courses lead to corruption."/>
    <meta name="author" content="Alexander Matrosov"/>
    <meta name="keywords" content="LUT, CourseSearch, course, calendar, time, management, timetable, Lappeenrannan, teknillinen, yliopisto, Lappeenranta, University, Technology, kurssi, lukujärjestys, lukkari, aikataulu, kurssihaku, kurssiaikataulu"/>

    <meta name="google-site-verification" content="jiAPQW_YaPR6HGl85wSwKeefLzgt13ivpespoLXyMmE" />
    <!-- for Facebook -->
    <meta property="og:title" content="CourseSearch LUT" />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="http://coursesearch.esy.es/images/calendar.png" />
    <meta property="og:url" content="http://coursesearch.esy.es/" />
    <meta property="og:description" content="CourseSearch is designed to reduce time used searching courses and collects all the necessary course data in one place. Course data is collected from UNI - portal, parsed and brought to user. Unfortunately data in UNI needs to be precise, which can in some courses lead to corruption." />

    <meta name="yandex-verification" content="1742cf0abcc2684e" />

    <link href="<?php echo $app_path;?>css/font-awesome.css" rel="stylesheet">

    <link href='<?php echo $app_path;?>css/fullcalendar.css' rel='stylesheet' />
    <link href='<?php echo $app_path;?>css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <link href='<?php echo $app_path;?>css/jquery-ui.css' rel='stylesheet'  />
    <link href='<?php echo $app_path;?>css/extra.css' rel='stylesheet'  />
    <link href='<?php echo $app_path;?>css/bootstrap-datetimepicker.css' rel='stylesheet'  />
    <link href="<?php echo $app_path;?>css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo $app_path;?>css/build.css">

    <link rel="stylesheet" href="https://developers.google.com//maps/documentation/javascript/demos/demos.css">

    <link rel="shortcut icon" href="<?php echo $app_path;?>images/favicon.ico" type="image/x-icon" />


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <script type="text/javascript" src='<?php echo $app_path;?>js/moment.min.js'></script>
    <script type="text/javascript" src='<?php echo $app_path;?>js/jquery.min.js'></script>
    <script type="text/javascript" src='<?php echo $app_path;?>js/fullcalendar.min.js'></script>
    <script type="text/javascript" src='<?php echo $app_path;?>js/fullcalendar.js'></script>
    <script type="text/javascript" src="<?php echo $app_path;?>js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo $app_path;?>js/typeahead.min.js"></script>
    <script type="text/javascript" src="<?php echo $app_path;?>js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo $app_path;?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $app_path;?>js/script.js"></script>
    <script type="text/javascript" src="<?php echo $app_path;?>js/timesheet.min.js"></script>


    <script type="text/javascript" src="<?php echo $app_path;?>js/js.cookie.js"></script>


    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>






    <title>CourseSearch</title>

  </head>
<body>


  <div id="fb-root"></div>

  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-71865086-1', 'auto');
    ga('send', 'pageview');

  </script>

  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/fi_FI/sdk.js#xfbml=1&version=v2.5";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>


<?php







//$_page = "location.php";

//echo $_GET['page'];

//Check given page that it its possible:
if(isset($_GET['page'])){
	if (isset($_SESSION['username'])){
		$pages=array(
      "frontpage",
      "timeline",
      "about",
      "comments",
      "calendar",
      "logout",
      "settings",
      "location",
      "room_schedule",
      "info",
      "overlaps",
      "upcoming",
      "inactive"
    );
	}else{
		$pages=array(
      "frontpage",
      "timeline",
      "about",
      "comments",
      "calendar",
      "login",
      "register",
      //"confirm",
      //"resend_email",
      "reset_password",
      //"create_new_password",
      "location",
      "room_schedule",
      "info",
      "overlaps",
      "upcoming",
      "inactive"
    );
	}
	if(in_array($_GET['page'], $pages)) {



			$_page=$_GET['page'];
      $_SESSION['last_page']=$_GET['page'];
      store_visitor_data($_page);
      //header("location:index.php");

	}else{
		$_page="calendar";
	}
}else{
	$_page="calendar";
}


// $uri = $_SERVER["REQUEST_URI"];
// $uriArray = explode('/', $uri);
// //$page_url = $uriArray[1];
// $page_url2 = $uriArray[2];
// echo $page_url2;
//
//
// print_r($uriArray);
// echo "<br>";
//
//
// $_page=$page_url2;
//
 //echo '<br>'.$_page;

 //echo __DIR__;

  require("header.php");
	require($_page.".php");
?>




</body>
</html>
