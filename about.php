
<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}
?>

<?php
// if (isset($_POST["feedback_email"]) && isset($_POST["feedback_message"])) {
//
// 	$email = htmlspecialchars($_POST['feedback_email']);
// 	$message = htmlspecialchars($_POST['feedback_message']);
//
// 	$headers = "MIME-Version: 1.0" . "\r\n";
// 	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// 	$headers .= "From: {$email}"."\r\n";
//  	mail('coursesearch@gmail.com', 'New feedback!', $message, $headers);
// }
?>

<div class="container">


	<div class="col-md-2"></div>
	<div class="col-md-8">
		<br>
	<div class="row">
	<h2 class="page-header">About</h2>


	<p>
		CourseSearch is designed to reduce time used searching courses and collects all the necessary course data in one place.
		Course data is collected from UNI - portal, parsed and brought to user. Some errors are possible as data in UNI needs to be precise, which can in some courses lead to data corruption (check below).
	</p>
	<p>
		Course database is as up to date as it is updated from <a href="https://uni.lut.fi/lukujarjestykset1" target="_blank">UNI-portal</a>.
	</p>
	<h3 class="page-header">Strange numbers</h3>
	<p>
		<img src="images/explain.JPG">
	</p>



	<h3 class="page-header">Known issues</h3>


			<b>Google calendar doesnt update events from CourseSearch</b><br>
			Delete old url cal and add as new, Google calendar loads calendar usually once when added as new and updates very lazily<br><br>
			<b>Data format incorrect in UNI - portal</b><br>
			For example:<br>
			BM20A5001 - Principles of Technical ComputingHR/07 in UNI, which should be:<br>
			BM20A5001 - Principles of Technical Computing/HR/07 <br><br>

			It would be great to receive notification about these irregular events! (See contact data below)<br><br>

			<b>Your event is inactive</b><br>
			Either some format issue, or event is added recently in last couple days. Database is updated daily or at least weekly.<br>
			You can also check <a href="index.php?page=inactive">event log</a> to see if event were changed.<br><br>
			<b>GPS - coordinates might be wrong</b><br>
			Some coordinates may be wrong, they were added in haste, so please always doublecheck location of your class room <br><br>

  <h3 class="page-header">Contact</h3>

		<p>
			Have you found some errors or do you have some ideas concerning this site?
		</p>
		<p>
			Help and ideas are really appreciated to improve CourseSearch in the future.
			<br><br>
			coursesearcher[at]gmail.com
			<!-- <a data-toggle="modal" data-target="#myModal2" ></a> -->
		</p>
    </div>
  </div>
</div>

</div>




<!-- <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="index.php?page=about"  role="form" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Feedback:</h4>
				</div>
				<div class="modal-body">
					<label for="comment">Your email: (for contact)</label>
					<input class="form-control" placeholder="email" name="feedback_email" type="text" required>

					<label for="comment">Your message:</label>
					<textarea class="form-control" placeholder="Your feedback" name="feedback_message" required></textarea>

					<input type="hidden" name="form_submission" >
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary" name="NEW_USER_CREATE">SEND FEEDBACK</button>
				</div>
			</form>
		</div>
	</div>

	</div> -->
	<div class="col-md-1"></div>

</div>
