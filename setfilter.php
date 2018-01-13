<?php

session_start();

if (isset($_GET['filter'])){
  if ($_GET['filter'] == 'COURSE'){
    $_SESSION['filter'] = 'COURSE';
  }elseif($_GET['filter'] == 'DEFAULT'){
    $_SESSION['filter'] = 'DEFAULT';
  }
}

echo $_SESSION['filter'];

header("location: calendar");

?>
