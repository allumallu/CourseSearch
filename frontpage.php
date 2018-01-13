<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}

if (isset($_POST["feedback_email"]) && isset($_POST["feedback_message"])) {
	$email = $_POST['feedback_email'];
	$message = $_POST['feedback_message'];

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: {$email}"."\r\n";
 	mail('coursesearch@coursesearch.esy.es', 'New feedback!', $message, $headers);
}
?>




<br><br>
	<div class="container">
		<div class="row text-center">
		  <h1 class="page-header">Welcome to CourseSearch</h1>
		  <p>
				Course search tool for students of LUT
			</p>
			<br>
			<p>
				<a href="<?php echo $app_path;?>about" class="btn btn-primary"><i class="fa fa-question-circle fa-1x"> About </i> </a>
				<a href="<?php echo $app_path;?>calendar" class="btn btn-success"><i class="fa fa-search fa-1x"> Start search </i> </a>
			</p>
		</div>
	</div>




<div id="test_session"></div>






<br><br>

<div class="container">
	<div class="row">
		<div class="col-sm-4 ">
		    <h3 class="page-header">Simple calendar</h2>

				<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Find your courses</p>
				<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Find your practise group</p>
				<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Filter lectures, practises, exams</p>
				<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Export ics-files</p>
				<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Google calendar links (beta)</p>
				<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Register and save your course list</p>
				<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Hide not needed events & print</p>


		</div>
		<div class="col-sm-4 ">

		  <h3 class="page-header">Check overlaps</h1>

			<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> See overlapping events</p>
			<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Remove overlapping courses</p>
			<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Links to overlapping date</p>


		</div>
		<div class="col-sm-4 ">

	    <h3 class="page-header">Detailed event info</h1>

			<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Event schedule</p>
			<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Location with map</p>
			<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Comments for events</p>
			<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Event descriptions</p>
			<p><i class="fa fa-check" aria-hidden="true" style="color: #5cb85c"></i> Direct links to portals</p>



		</div>
	</div>
</div>

<br><br>

<div class="footer-below">
		<div class="container">
				<div class="row">
						<div class="col-lg-12">

							<ul class="share-buttons">
								<li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fcoursesearch.esy.es%2F&t=CourseSearch" target="_blank" title="Share on Facebook"><i class="fa fa-facebook-official fa-2x"></i></a></li>
								<li><a href="https://twitter.com/intent/tweet?source=http%3A%2F%2Fcoursesearch.esy.es%2F&text=CourseSearch:%20http%3A%2F%2Fcoursesearch.esy.es%2F" target="_blank" title="Tweet"><i class="fa fa-twitter fa-2x"></i></a></li>
								<li><a href="https://www.instagram.com/coursesearch/" target="_blank" title="Instagram"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a></li>
								<li><a href="https://plus.google.com/share?url=http%3A%2F%2Fcoursesearch.esy.es%2F" target="_blank" title="Share on Google+"><i class="fa fa-google-plus fa-2x"></i></a></li>
								<li><a href="http://www.tumblr.com/share?v=3&u=http%3A%2F%2Fcoursesearch.esy.es%2F&t=CourseSearch&s=" target="_blank" title="Post to Tumblr"><i class="fa fa-tumblr fa-2x"></i></a></li>
								<li><a href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fcoursesearch.esy.es%2F&description=Unofficial%20course%20search%20tool%20for%20LUT%20students.%20Lectures%2C%20seminars%2C%20practises%2C%20exams%2C%20changes%20and%20personal%20events%20under%20the%20same%20roof!" target="_blank" title="Pin it"><i class="fa fa-pinterest fa-2x"></i></a></li>
								<li><a href="http://www.reddit.com/submit?url=http%3A%2F%2Fcoursesearch.esy.es%2F&title=CourseSearch" target="_blank" title="Submit to Reddit"><i class="fa fa-reddit fa-2x"></i></a></li>
								<li><a href="mailto:?subject=CourseSearch&body=Unofficial%20course%20search%20tool%20for%20LUT%20students.%20Lectures%2C%20seminars%2C%20practises%2C%20exams%2C%20changes%20and%20personal%20events%20under%20the%20same%20roof!:%20http%3A%2F%2Fcoursesearch.esy.es%2F" target="_blank" title="Email"><i class="fa fa-envelope fa-2x"></i></a></li>
								<li><a href="whatsapp://send?text=http%3A%2F%2Fcoursesearch.esy.es%2F" target="_blank" title="Whatsapp"><i class="fa fa-whatsapp fa-2x"></i></a></li>
							</ul>

						</div>

				</div>
		</div>
</div>

<footer>



</footer>






	<!-- /.row -





<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

</div>
