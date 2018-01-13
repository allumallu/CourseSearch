
<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}
?>

<div class="container">

  <h1>Login</h1>
	<p>Access your saved courses!</p>
  <p><?php if(isset($error_mes)){echo $error_mes;} ?></p>






  <div class="col-md-4">
    <form  action="index.php?page=login"  role="form" method="post" id="login_form1">
      <fieldset>
        <div class="form-group">
          <input class="form-control" placeholder="Username" name="userName" type="text" autofocus required>
        </div>
        <div class="form-group">
          <input class="form-control" placeholder="Password" name="passWord" type="password" value="" required>
        </div>
				<div class="form-group">
          <input class="btn btn-success" name="Submit_login" type="submit" value="Sign in">
        </div>
				<div>
					<a href="index.php?page=register">Create account</a> or <a href="index.php?page=reset_password">reset password</a>
				</div>




      </fieldset>
    </form>

  </div>

</div>
