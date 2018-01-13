<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}
?>

<div class="container">
	<div class="col-md-12">
		<h1>User <?php if (isset($_SESSION['username'])){ echo $_SESSION['username']; } ?>:</h1>
	  <p>Here you can modify your email, set reminders and see your saved courses:</p>

		<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-exclamation-sign" style="color:red"></span> Reminders are still under development, suggestions are welcome!
		</div>

	  <h3>Your settings: </h3>
	  <p><label for="comment">Email: </label> <?php if (isset($_SESSION['user_email'])) { echo $_SESSION['user_email'];} ?></p>
		<p><label for="comment">Receive reminders: </label> <?php if (isset($_SESSION['reminders'])) echo $_SESSION['reminders'];?></p>
		<p><label for="comment">Receive email when new comment is written: </label> <?php if (isset($_SESSION['reminder2'])) echo $_SESSION['reminder2'];?></p>
		<p>
			<a class="btn btn-sm btn-default" data-toggle="modal" data-target="#myModal2"> Edit settings </a>
			<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeUser_conf"> Delete user </a>
		</p>




	</div>
</div>

<script>



	$(document).ready(function() {


	  //Script for datetimepickers:
		$("#pvm").datetimepicker({
			format: 'yyyy-mm-dd hh:ii',
			weekStart: 1,
			autoclose: true
		});

		$("#pvm2").datetimepicker({
			format: 'yyyy-mm-dd hh:ii',
			weekStart: 1,
			autoclose: true
		});
	});
</script>

<div class="modal fade" id="removeUser_conf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Remove your user?</h4>
			</div>
			<div class="modal-body">
				WARNING!<br>
				All data for user will be removed and it will be impossible to restore user courses, comments.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger">Proceed</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="courseinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Course_info</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="index.php" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Create new event:</h4>
				</div>
				<div class="modal-body">
					<label for="comment">Event name:</label>
					<input class="form-control" type="text" name="event_name"  placeholder="Short event name" required />

					<label for="comment">Start datetime:</label>
					<div class='input-group date' id='pvm'>
						<input class="form-control" type="text" name="start_time" placeholder="Start datetime" required />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
					<label for="comment">End datetime:</label>
					<div class='input-group date' id='pvm2'>
						<input class="form-control" type="text" name="end_time" placeholder="End datetime" required />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>

					<label for="comment">Comment:</label>
					<textarea input class="form-control" name="event_description" rows="5" id="comment" required></textarea>
					<label for="comment">Event location (Optional):</label>
					<input class="form-control" type="text" name="event_location"  placeholder="Event location" required />

					<input type="hidden" name="form_submission" >
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success" name="NEW_USER_CREATE" >Save note</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="index.php"  role="form" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Modify your email:</h4>
        </div>
        <div class="modal-body">
          <label for="comment">Current email:</label>
          <input class="form-control" placeholder="email" name="email" type="text" value="<?php if (isset($_SESSION['user_email'])) { echo $_SESSION['user_email'];} ?>"  required>

          <label for="comment">Receive reminders?</label>

          <div class="radio">
            <label><input name="reminder" type="radio" value="FALSE" <?php if (isset($_SESSION['reminders']) && $_SESSION['reminders']=="FALSE") echo "checked";?> required>No please</label>
          </div>
          <div class="radio">
            <label><input name="reminder" type="radio" value="TRUE" <?php if (isset($_SESSION['reminders']) && $_SESSION['reminders']=="TRUE") echo "checked";?> required>Yes (every morning)</label>
          </div>

					<label for="comment">Receive email when new comment is available?</label>

          <div class="radio">
            <label><input name="reminder2" type="radio" value="FALSE" <?php if (isset($_SESSION['reminder2']) && $_SESSION['reminder2']=="FALSE") echo "checked";?> required>No please</label>
          </div>
          <div class="radio">
            <label><input name="reminder2" type="radio" value="TRUE" <?php if (isset($_SESSION['reminder2']) && $_SESSION['reminder2']=="TRUE") echo "checked";?> required>Yes</label>
          </div>

          <label for="comment">Type password to change:</label>
          <input class="form-control" placeholder="Type your password to change email" name="passWord" type="password" value="" required>

          <input type="hidden"  name="form_submission" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" name="NEW_USER_CREATE" >Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
