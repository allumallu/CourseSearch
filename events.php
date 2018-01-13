<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}
?>
<div class="col-md-1">
</div>
<div class="col-md-10">

	<form class="navbar-form navbar-left" style="display:table;"  method="post" action="" id="my-form" role="search">
			<div class="form-group">
				<input type="text" name="search" id="searchbox1123"  placeholder="Course name or id" autofocus/>
			</div>
		</form>
		<br>


			<h1  class="page-header"><?php
			if (isset($_SESSION['username'])){
				echo $_SESSION['username'];
			}else{
				echo 'Guest ';
			} ?> courses</h1>





			<div class="span2" id='calendar'></div>



			<div class="dropdown">
			  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			    DOWNLOAD *.ICS
			    <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			    <li><a href="output_exams.php"><span class="glyphicon glyphicon-download" aria-hidden="true"> EXAMS</span></a></li>
					<li role="separator" class="divider"></li>
			    <li><a href="output_events.php"><span class="glyphicon glyphicon-download" aria-hidden="true"> COURSE EVENTS</span></a></li>
					<li role="separator" class="divider"></li>
			    <li><a href="output_personal_events.php"><span class="glyphicon glyphicon-download" aria-hidden="true"> PERSONAL EVENTS</span></a></li>
			  </ul>
				<?php if (isset($_SESSION['userID'])){
					echo ' <button class="btn btn-default" id="modal_form1" data-toggle="modal" data-target="#myModal">ADD PERSONAL EVENT</button> ';
					echo ' <button class="btn btn-default" data-toggle="modal" data-target="#myModal3">URL LINK</button> ';
				}?>

				<button class="btn btn-default" onclick="myFunction()">PRINT</button>
			</div>



			<br>

			<div class="event_type_checkbox">
				FILTERS:
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="EXAM" value="EXAM" checked>
						<label for="EXAM"> EXAM </label>
				</div>
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="LECTURE" value="LECTURE" checked>
						<label for="LECTURE"> LECTURE </label>
				</div>
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="EXERCISE" value="EXERCISE" checked>
						<label for="EXERCISE"> EXERCISE </label>
				</div>
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="SEMINAR" value="SEMINAR" checked>
						<label for="SEMINAR"> SEMINAR </label>
				</div>
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="MIXED" value="MIXED" checked>
						<label for="MIXED"> MIXED </label>
				</div>
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="INTENSIVE" value="INTENSIVE" checked>
						<label for="INTENSIVE"> INTENSIVE </label>
				</div>
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="DEMO" value="DEMO" checked>
						<label for="DEMO"> DEMO </label>
				</div>
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="PERSONAL" value="PERSONAL" checked>
						<label for="PERSONAL"> PERSONAL </label>
				</div>
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="INACTIVE" value="INACTIVE" checked>
						<label for="INACTIVE"> INACTIVE </label>
				</div>
				<div class="checkbox checkbox-primary checkbox-inline">
						<input type="checkbox" name="event_type" class="styled" id="checkAll" checked>
						<label for="checkAll"> Check all </label>
				</div>
			</div>
			<div class="col-md-4">
				<div class="loader2">Searching next events... <img src="images\page-loader.gif" ></div>
			</div>
			<div class="col-md-4">
				<div class="loader3">Searching next exams...  <img src="images\page-loader.gif" ></div>
			</div>
			<div class="col-md-4">
				<div class="loader1">Calculating overlaps...  <img src="images\page-loader.gif" ></div>
			</div>
			<br>

			<div class="col-md-4">
				<?php //output_next_events2(); ?>

				<div id="next_events"></div>
			</div>
			<div class="col-md-4">
				<?php //output_next_exams2(); ?>

				<div id="next_exams"></div>
			</div>
			<div class="col-md-4">
				<div id="course_overlaps"></div>

			</div>


</div>

<div class="col-md-1"></div>




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
