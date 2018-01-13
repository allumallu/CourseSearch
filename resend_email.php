

<div class="container">
  <h1>Resend activation link to Email</h1>
  <p>In case of problems, contact coursesearch@esy.es</p>


  <?php

  if (isset($_SESSION)){

  }else{
    header("location: index.php");
  }

  if (isset($_POST["resend_email"])) {

      echo resend_activation_email($_POST["resend_email"]);

  }
  ?>


  <div class="col-md-6">
    <form id="resend_email_form" class="form-inline-block" action="#" method="post">

       <div class="form-group">
           <input class="form-control" placeholder="Your email" name="resend_email" value="" type="text" autofocus>
       </div>
        <div class="form-group">
        <input class="btn btn-success" name="Submit_login" type="submit" value="Send new email">
        </div>
    </form>
	</div>



</div>
