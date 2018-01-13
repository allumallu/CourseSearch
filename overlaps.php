<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}
?>

<div class="container">
	<div class="row">
		<h2 class="header">Overlaps</h2>
		<p>All your session course events are compared against each other. If some events overlaps, they are shown here. Please <a href="about">report</a> if some events are missing or shown incorrect</p>
		<div class="loader1">Calculating overlaps...  <img src="images\page-loader.gif" ></div>
		<div id="course_overlaps"></div>

	</div>

</div>
