<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}
?>
<div class="container">

<div class="row">

	<form class="navbar-form " style="display:table;"  method="post" action="" id="my-form" role="search">
		<div class="form-group">
			<input type="text" name="search" id="searchbox1123"  placeholder="Course name or id" autofocus/>
		</div>
	</form>



<!-- <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-envelope" aria-hidden="true"> </span> Please help to improve Coursesearch and fill out this <a href="https://goo.gl/forms/twkvkTwCooMwqvyg2" target="_blank">survey</a></div> -->
	<h1  class="page-header"><?php
	if (isset($_SESSION['username'])){
		echo $_SESSION['username'].' courses ';
		echo 	'	<a href="logout.php" class="btn btn-default btn-xs">Logout</a>';
	}else{
		echo 'Guest  ';
		echo '	<a href="'.$app_path.'login" class="btn btn-success btn-xs">Login</a>
			<a href="'.$app_path.'register" class="btn btn-primary btn-xs">Register</a>';
	} ?>


	</h1>
	Filter by
	<?php

	//print_r($_SESSION);

	if(isset($_SESSION['filter'])){
		if ($_SESSION['filter']=='COURSE'){
				echo 'courses / <a href="setfilter.php?filter=DEFAULT">   event type</a>';
			}else{
				echo '<a href="setfilter.php?filter=COURSE">courses / </a> event type ';
			}

	}else{
		$_SESSION['filter']='DEFAULT';
		echo 'courses / <a href="setfilter.php?filter=COURSE">event type</a>';
	}

	?>
<BR><BR>
	<div class="event_type_checkbox">

	<?php



	if ($_SESSION['filter']=='COURSE'){
		if (isset($_SESSION['courses']) && count($_SESSION['courses']) > 0){


			$color_arr = array(
				'#008B8B',
				'#00BFFF',
				'#00CED1',
				'#1E90FF',
				'#2E8B57',
				'#2F4F4F',
				'#3CB371',
				'#4682B4',
				'#4169E1',
				'#66CDAA',
				'#808000',
				'#8B4513',
				'#A0522D',
				'#D2691E',
				'#DC143C',
				'#6687FF',
				'#8887FF',
				'#9987FF',
				'#3387FF',
				'#3387FF',
				'#3387FF',
				'#3387FF',
				'#3387FF',
				'#3387FF',
				'#3387FF',
				'#3387FF'
			);

			$course_color = array();
			$idd=0;

			foreach($_SESSION['courses'] as $t_id => $value) {
				echo '<div class="checkbox checkbox-default " >';
				echo '	<input type="checkbox" name="event_course" class="styled" id="'.$t_id.'" value="'.$t_id.'"  checked>';
				echo '	<label for="'.$t_id.'" style="color: '.$color_arr[$idd].'"> '.$value.' </label>';
				echo '</div>';
				$idd++;
			}
			echo '<div class="checkbox checkbox-default checkbox-inline">';
			echo '<input type="checkbox" name="event_course" class="styled" id="checkAll" checked>';
			echo '<label for="checkAll"> Check all </label>';
			echo '</div>';
		}
	}else{
		$type = array('EXAM', 'L', 'H', 'S', 'L+H', 'L+S', 'INT', 'DL', 'ML', 'LAB', 'PERSONAL', 'INACTIVE');

		foreach ($type as $item){
			echo '<div class="checkbox checkbox-default checkbox-inline" >';
			echo '	<input type="checkbox" name="event_type" class="styled" id="'.$item.'" value="'.$item.'"  checked>';
			echo '	<label for="'.$item.'"> '.$item.' </label>';
			echo '</div>';
		}

		echo '<div class="checkbox checkbox-default checkbox-inline">';
		echo '<input type="checkbox" name="event_type" class="styled" id="checkAll" checked>';
		echo '<label for="checkAll"> Check all </label>';
		echo '</div>';
	}


	?>
</div>
	<br>
	<!-- FULLCALENDAR DIV -->
	<div class="span2" id='calendar'></div>
	<br>
	<!-- BUTTON DIV -->
	<div class="dropdown">
		<button class="btn btn-default" onclick="myFunction()">PRINT</button>
	  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
	    DOWNLOAD *.ICS
	    <span class="caret"></span>
	  </button>

	  <ul class="dropdown-menu dropup" aria-labelledby="dropdownMenu1">
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


	</div>
	<br>
	In case you encounter some problems with CourseSearch events, please see <a href="about">About</a> - page<br><br>
	<script>  function myFunction() {window.print();}</script>

</div>
</div>





<!-- MODAL FORMS -->

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
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
					<h4 class="modal-title" id="myModalLabel"><div id="event_name_1">1</div></h4>

					<button type="submit" id="hide_event_button" class="btn btn-warning btn-xs pull-right"  data-dismiss="modal" name="Delete"> Hide from view </button>


					<!--<button type="submit" id="hide_event_button" class="btn btn-warning pull-right"  data-dismiss="modal" name="Delete"> Hide </button>
					<button type="button" class="btn btn-default pull-right" data-dismiss="modal"> Ok </button>
					<br>-->
					<!--<div id="event_updated"></div>-->

				</div>


				<div class="modal-body">
					<div id="event_start_1">event_start_1</div>
					<div id="event_location_1">event_location_1</div>
					<div id="event_comment_1">event_comment_1</div>
					<div id="event_comment_2"><div class="loader4">Loading comments... <img src="images\page-loader.gif" ></div></div>
					<div id="event_popularity"></div>
					<div id="event_info"></div>

					<!--<div id="courseinfo_button"><a href="#" class="btn" id="load_weboodi">Weboodi info</button></a>-->
					<div id="courseinfo_button"></div>
					<div id="courseinfo_weboodi"></div>

					<input type="hidden" id="hide_event_id" name="event_id" >
					<div id="event_updated"></div>
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
