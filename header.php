<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}

$width_of_courses = 42;
$user_name = "Guest";
$course_count = 0;

if (isset($_SESSION['courses'])){
	$course_count = count($_SESSION['courses']);
}

if (isset($_SESSION['username'])){
	$user_name = $_SESSION['username'];
}

?>
<nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $app_path;?>frontpage">COURSESEARCH</a>
    </div>
		<div class="navbar-collapse collapse" id="navbar">


			<ul class="nav navbar-nav">
		    <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
				    <span class="glyphicon glyphicon-folder-open" aria-hidden="true"> Courses (<?php echo $course_count?>) </span> 
						<span class="caret"></span>
					</a>
		    <ul class="dropdown-menu" role="menu">
					<li><a class="glyphicon glyphicon-search" href="<?php echo $app_path;?>calendar" style="font-size: 150%;"> Search courses </a></li>
					<li class="divider"></li>
					<li><a class="glyphicon glyphicon-search" href="<?php echo $app_path;?>room_schedule" style="font-size: 150%;"> Check class rooms </a></li>
					<li class="divider"></li>
					<li><a class="glyphicon glyphicon-info-sign"  href="<?php echo $app_path;?>info" style="font-size: 150%;"> Course info </a></li>
					<li class="divider"></li>

					<?php
					if ($user_name == "Guest"){
					}else{
						echo '<li><a class="glyphicon glyphicon-floppy-disk" href="'.$app_path.'save_course_list.php" style="font-size: 150%;"> Save current courses </a></li>';
						echo '<li class="divider"></li>';
					}
			    if(isset($_SESSION['courses']) && count($_SESSION['courses'])>0){
						echo '<li><a class="glyphicon glyphicon-trash" href="'.$app_path.'unset_course.php?action=deleteALL" style="font-size: 150%;"> Empty courselist </a></li>';
						echo '<li class="divider"></li>';
			      foreach($_SESSION['courses'] as $id => $value){
							echo '<form class="form-inline" action="'.$app_path.''.$_page.'" method="post">';
							echo '<input type="hidden" name="remove_course_from_session">';
							echo '<input type="hidden" name="course_id" value='.str_replace(' ','_',$id).'>';
							echo '<li id="list_set"> <b>'.$id.'</b><input class="btn btn-danger pull-right" type="submit" value="X"> '.str_replace($id.' -', '', $value).'</li>';
							echo '</form><hr>';
			      }
			    }else{
						echo '<li><a class="glyphicon glyphicon-question-sign" href="'.$app_path.'calendar" style="font-size: 150%;"> Start by writing course name!</a></li>';
					}
					?>
				</ul>
			</ul>

			<ul class="nav navbar-nav navbar-left" >
				<li><a class="glyphicon glyphicon-question-sign" href="<?php echo $app_path;?>about"> </a></li>

				<li><a href="<?php echo $app_path;?>upcoming" > <span class="glyphicon glyphicon-time" id="next_amount"> <img src="<?php echo $app_path;?>images\ajax-loader.gif" >  </span> </a></li>
				<li><a href="<?php echo $app_path;?>inactive" > <span class="glyphicon glyphicon-list-alt" id="changes_amount"> <img src="<?php echo $app_path;?>images\ajax-loader.gif" >  </span> </a></li>
				<li><a href="<?php echo $app_path;?>overlaps" > <span class="glyphicon glyphicon-warning-sign" id="overlaps_amount"> <img src="<?php echo $app_path;?>images\ajax-loader.gif" >  </span> </a></li>
				<li><a href="<?php echo $app_path;?>comments" > <span class="glyphicon glyphicon-comment" id="comments_amount"> <img src="<?php echo $app_path;?>images\ajax-loader.gif" >  </span> </a></li>
			</ul>



			<ul class="nav navbar-nav navbar-right">
		    <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
				    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $user_name?>
						<span class="caret"></span>
					</a>
		    <ul class="dropdown-menu" role="menu">
					<?php
					if ($user_name == "Guest"){
						echo '<li><a class="glyphicon glyphicon-log-in" href="'.$app_path.'login" style="font-size: 150%;"> Login </a></li>';
						echo '<li class="divider"></li>';
						echo '<li><a class="glyphicon glyphicon-pencil" href="'.$app_path.'register" style="font-size: 150%;"> Register </a></li>';

					}else{
						echo '<li><a class="glyphicon glyphicon-cog" href="'.$app_path.'settings" style="font-size: 150%;"> Settings </a></li>';
						echo '<li class="divider"></li>';
						echo '<li><a class="glyphicon glyphicon-log-out" href="'.$app_path.'logout.php" style="font-size: 150%;"> Logout </a></li>';

					}
					?>
				</ul>
				</ul>
			</div>
	</div>
</nav>

<script>

var url_site34 = "<?php echo $app_path;?>includes/calculate_overlaps.php";
$('#overlaps_amount').load(url_site34.toString());

var url_site35 = "<?php echo $app_path;?>includes/calculate_changes.php";
$('#changes_amount').load(url_site35.toString());

var url_site36 = "<?php echo $app_path;?>includes/calculate_comments.php";
$('#comments_amount').load(url_site36.toString());

var url_site37 = "<?php echo $app_path;?>includes/calculate_next.php";
$('#next_amount').load(url_site37.toString());

</script>
