


<div class="container">
  <h1>Account activation</h1>
  <p>In case of problems, contact coursesearch@esy.es</p>
  <?php

  if (isset($_SESSION)){

  }else{
  	header("location: index.php");
  }



  if (isset($_GET['conf_id'])){
    //echo $_GET['conf_id'];
    echo activate_user($_GET['conf_id']);
  }


  ?>

</div>
