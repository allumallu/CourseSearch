<?php
if (isset($_SESSION)){

}else{
	header("location: index.php");
}

$error_mes = "";
if (isset($_POST["new_name"]) and isset($_POST["new_pass1"]) and isset($_POST["new_pass2"])) {
    if(!preg_match('/^(?=.*\d)(?=.*[a-zA-Z]).{6,25}$/', $_POST["new_pass1"])) {
        $error_mes = '<div class="alert alert-danger" role="alert">Password must be 8-256 char long, contain numbers, big or small letters!</div>';
    }else{
        if ($_POST["new_pass1"] === $_POST["new_pass2"]){

          $return_string = register_new_user($_POST["new_name"], $_POST["new_pass1"]);
          if($return_string === 0){
            $error_mes =  '<div class="alert alert-danger" role="alert">Username already in use!</div>';
          }elseif($return_string === 2){
            $error_mes =  '<div class="alert alert-success" role="alert">Registration complete! You can now <a href="login">login!</a></div>';
          }else{
              $error_mes =  "Problem with registration, please try again or contact: coursesearch@coursesearch.esy.es";
          };
        }else{
            $error_mes =  '<div class="alert alert-danger" role="alert">Passwords do not match!</div>';
        }
    }
}
?>


<div class="container">
  <h1>Register</h1>
  <p>Register now, and keep track of your courses</p>

  <div class="alert alert-warning" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" style="color:red"></span> Please use unique username and password which aren't used anywhere else. (Website security is under development!)
	</div>


  <p><?php if(isset($error_mes)){echo $error_mes;} ?></p>
  <div class="col-md-6">
    <form id="register_form" class="form-inline-block" action="#" method="post">
       <div class="form-group">
           <input class="form-control" placeholder="Username" name="new_name" value="<?php if(isset($_POST["new_name"])){echo $_POST["new_name"];} ?>" type="text" autofocus required>
       </div>
       <div class="form-group">
            <input class="form-control" placeholder="Password" name="new_pass1" type="password" required>
       </div>
       <div class="form-group">
           <input class="form-control" placeholder="Re-type Password" name="new_pass2" type="password" required>
       </div>
        <div class="form-group">
        <input class="btn btn-success" name="Submit_login" type="submit" value="Register!">
        </div>
    </form>
	</div>
</div>
