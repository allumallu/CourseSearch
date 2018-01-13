<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}
?>

<div class="container">


	<div class="row">

		<?php
			echo show_course_changes_new_newest_events();
			?>

	</div>

	<div class="row">

		<?php
			echo show_course_changes_new();
			?>

	</div>



</div>
