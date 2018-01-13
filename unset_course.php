<?php

session_start();

//remove course by given id
if(isset($_GET['action'])){


  if($_GET['action']=="delete"  && isset($_GET['id'])){

    if(isset($_SESSION['courses'][$id])){
      $id=$_GET['id'];
      echo $id;
      //echo $_SESSION['courses'][$id];
      // print_r($_SESSION['courses']);
  		unset($_SESSION['courses'][$id]);
      //unset($_SESSION['courses']);
  	}
  }elseif($_GET['action']=="deleteALL"){
    if(isset($_SESSION['courses'])){
      print_r($_SESSION['courses']);
      unset($_SESSION['courses']);
      //unset($_SESSION['courses']);
    }
  }elseif($_GET['action']=="delete_mycourse"){
    foreach($_SESSION['courses'] as $id1 => $value){

      if ($_SESSION['courses'][$id1]==$id){
          unset($_SESSION['courses'][$id1]);
          remove_user_course($id);
      }
    }
    //remove personal event by given id
  }elseif($_GET['action']=="delete_from_db"){
      if (isset($_SESSION['courses'][$id])){
          unset($_SESSION['courses'][$id]);
          save_course_list();
      }

    //remove personal event by given id
  }elseif($_GET['action']=="delete_personal_event"){
    //echo $id;

    remove_personal_event($id);
  }
}



header("location: calendar");

?>
