
<div class="container">
  <h1>Create new password</h1>
  <p>Password must be 8-256 char long, contain numbers, big or small letters!</p>

  <?php

  if (isset($_SESSION)){

  }else{
  	header("location: index.php");
  }

  if (isset($_GET['passToken'])){

    $token = mysqli_real_escape_string($link, $_GET['passToken']);

    if (check_if_token_exists($token)){

      echo '<div class="col-md-6">';
      echo '  <form id="create_new_password" class="form-inline-block" action="#" method="post">';
      echo '    <div class="form-group">';
      echo '      <input class="form-control" placeholder="New password" name="new_pass1" type="password" required>';
      echo '    </div>';
      echo '    <div class="form-group">';
      echo '      <input class="form-control" placeholder="Re-type new password" name="new_pass2" type="password" required>';
      echo '    </div>';
      echo '    <div class="form-group">';
      echo '      <input class="btn btn-success" name="Submit_login" type="submit" value="Register!">';
      echo '    </div>';
      echo '    <input type="hidden" name="token" value="'.$token.'"/>';
      echo '  </form>';
      echo '</div>';
    }else{
      echo 'wrong token!';
    }

    //$message = create_new_password($_GET['passToken']);
    //echo $message;
  }else{
    echo 'wrong token!';
  }


  if (isset($_POST["new_pass1"]) && isset($_POST["new_pass2"]) && isset($_POST["token"])) {
      echo reset_password($_POST["new_pass1"], $_POST["new_pass2"], $_POST["token"]);
  }


  ?>

</div>
