<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}
?>

<div class="container">


			<div class="row">

				<div id="next_events"></div>
			</div>


</div>




	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="index.php?events.php" method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Create new personal event:</h4>
					</div>
					<div class="modal-body">
						<label for="comment">Event name:</label>
						<input class="form-control" type="text" name="event_name"  placeholder="Short event name" required autofocus/>

						<label for="comment">Start datetime:</label>
						<div class='input-group date' id='pvm'>
							<input class="form-control" type="text" id="start_time" name="start_time" placeholder="Start datetime" required />
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
						<label for="comment">End datetime:</label>
						<div class='input-group date' id='pvm2'>
							<input class="form-control" type="text" id="end_time" name="end_time" placeholder="End datetime" required />
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



	<div class="modal fade" id="myModal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="index.php?events.php" method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Edit personal event:</h4>
					</div>
					<div class="modal-body">
						<label for="comment">Event name:</label>
						<input class="form-control" type="text" id="event_name" name="event_name"  placeholder="Short event name" required autofocus/>

						<label for="comment">Start datetime:</label>
						<div class='input-group date' id='pvm3'>
							<input class="form-control" type="text" id="start_time2" name="start_time" placeholder="Start datetime" required />
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
						<label for="comment">End datetime:</label>
						<div class='input-group date' id='pvm4'>
							<input class="form-control" type="text" id="end_time2" name="end_time" placeholder="End datetime" required />
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>

						<label for="comment">Comment:</label>
						<textarea input class="form-control" name="event_description" rows="5" id="comment_field" required></textarea>
						<label for="comment">Event location (Optional):</label>
						<input class="form-control" type="text" id="event_location" name="event_location"  placeholder="Event location" required />

						<input type="hidden" id="event_id" name="event_id" >
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-warning" name="Delete">Delete</button>
						<button type="submit" class="btn btn-success" name="Save">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>



	<div class="modal fade" id="myModal_remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><div id="event_name_1">1</div></h4>
						<!--<button type="submit" id="hide_event_button" class="btn btn-warning pull-right"  data-dismiss="modal" name="Delete"> Hide </button>
						<button type="button" class="btn btn-default pull-right" data-dismiss="modal"> Ok </button>
						<br>-->
						<div id="event_updated"></div>

					</div>


					<div class="modal-body">
						<div id="event_start_1">event_start_1</div>
						<div id="event_location_1">event_location_1</div>
						<div id="event_comment_1">event_comment_1</div>
						<div id="event_comment_2"><div class="loader4">Loading comments... <img src="images\page-loader.gif" ></div></div>
						<!--<div id="event_comment_3"></div> -->

						<input type="hidden" id="hide_event_id" name="event_id" >
					</div>
					<div class="modal-footer">

						<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
						<button type="submit" id="hide_event_button" class="btn btn-warning"  data-dismiss="modal" name="Delete">Hide</button>
					</div>

			</div>
		</div>
	</div>

	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Copy this link and get your events to Google Calendar!</h4>
					</div>
					<div class="modal-body">

						<?php

						if (isset($_SESSION['userID'])){
								$user_id = $_SESSION['userID'];



							 	echo return_user_token($user_id);
						}else{
								echo 'Please login!';
						}
						?>

						<input type="hidden" id="hide_event_id" name="event_id" >
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-warning"  data-dismiss="modal">Close</button>
					</div>

			</div>
		</div>
	</div>
