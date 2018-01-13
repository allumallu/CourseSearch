<?php
if (isset($_SESSION)){
}else{
	header("location: index.php");
}
?>
<div class="col-md-1">
</div>
<div class="col-md-10">


			<h1  class="page-header">Timeline</h1>

			<form class="form" action="" method="post">
				<label for="comment">Date:</label>
				<input class="form-control" type="text" id='searchForm' name="user_date" placeholder="Start datetime" required />
				<button type="submit" class="btn btn-success" name="Search">Search</button>
			</form>

<script>
$("#searchForm").datepicker({
	dateFormat: 'yy-mm-dd'
});
</script>

<div class="timesheet color-scheme-default" id="timesheet-default"><div class="scale"><section>2002</section><section>2003</section><section>2004</section><section>2005</section><section>2006</section><section>2007</section><section>2008</section><section>2009</section><section>2010</section><section>2011</section><section>2012</section><section>2013</section></div><ul class="data"><li><span class="bubble bubble-lorem" style="margin-left: 0px; width: 45px;" data-duration="6"></span><span class="date">2002-09/2002</span> <span class="label">A freaking awesome time</span></li><li><span class="bubble bubble-ipsum" style="margin-left: 25px; width: 80px;" data-duration="12"></span><span class="date">06/2002-09/2003</span> <span class="label">Some great memories</span></li><li><span class="bubble bubble-default" style="margin-left: 60px; width: 60px;" data-duration=""></span><span class="date">2003</span> <span class="label">Had very bad luck</span></li><li><span class="bubble bubble-dolor" style="margin-left: 105px; width: 135px;" data-duration="21"></span><span class="date">10/2003-2006</span> <span class="label">At least had fun</span></li><li><span class="bubble bubble-ipsum" style="margin-left: 185px; width: 80px;" data-duration="12"></span><span class="date">02/2005-05/2006</span> <span class="label">Enjoyed those times as well</span></li><li><span class="bubble bubble-default" style="margin-left: 210px; width: 15px;" data-duration="2"></span><span class="date">07/2005-09/2005</span> <span class="label">Bad luck again</span></li><li><span class="bubble bubble-dolor" style="margin-left: 225px; width: 135px;" data-duration="21"></span><span class="date">10/2005-2008</span> <span class="label">For a long time nothing happened</span></li><li><span class="bubble bubble-lorem" style="margin-left: 360px; width: 85px;" data-duration="12"></span><span class="date">01/2008-05/2009</span> <span class="label">LOST Season #4</span></li><li><span class="bubble bubble-sit" style="margin-left: 420px; width: 25px;" data-duration="3"></span><span class="date">01/2009-05/2009</span> <span class="label">LOST Season #4</span></li><li><span class="bubble bubble-lorem" style="margin-left: 485px; width: 20px;" data-duration="2"></span><span class="date">02/2010-05/2010</span> <span class="label">LOST Season #5</span></li><li><span class="bubble bubble-ipsum" style="margin-left: 400px; width: 110px;" data-duration="16"></span><span class="date">09/2008-06/2010</span> <span class="label">FRINGE #1 &amp; #2</span></li></ul></div>

<!-- <table class="table table-bordered"> -->
<!-- <table> -->
<?php

// echo '<tr>';
//
// echo '<td>Course</td>';
// for ($y = 0; $y <= 4; $y++) {
// 	for ($x = 8; $x <= 18; $x++) {
// 			echo '<td>'.$x.'</td>';
// 	}
// }
// echo '</tr>';
//2017-03-09 00:00:00

$search_date = 	date("Y-m-d");

if (isset($_POST['user_date'])){
	$search_date = $_POST['user_date'];
	echo $search_date;
}

// if (isset($_SESSION['courses']) && count($_SESSION['courses']) > 0){
//
//
// 	foreach($_SESSION['courses'] as $t_id => $value) {
// 		echo '<tr>';
// 		echo '<td>'.$value.'</td>';
//
// 		for ($y = 0; $y <= 4; $y++) {
//
// 			$date = date('Y-m-d', strtotime($search_date . " + ".$y." day"));
//
// 			for ($x = 8; $x <= 18; $x++) {
// 				$query = "SELECT event_type, event_name, start_time, end_time FROM timetable where
// 				start_time = '{$date}' + INTERVAL ".$x." HOUR  and course = '".$t_id."'
//
// 				or end_time >= '{$date}' + INTERVAL ".($x+1)." HOUR and start_time <= '{$date}' + INTERVAL ".$x." HOUR and course = '".$t_id."'";
// 				//echo $query;
//
// 				if ($result = mysqli_query($link, $query)){
// 					if (mysqli_num_rows(mysqli_query($link, $query))>0){
// 						while ($row = mysqli_fetch_assoc($result)){
// 						//	echo '<td bgcolor="#000000"></td>';
// 							 echo '<td bgcolor="#000000"></td>';
// 							//
// 						}
// 					}else{
// 						echo '<td></td>';
// 					}
// 				}else{
// 					echo '<td></td>';
// 				}
// 			}
// 		}
// 		echo '</tr>';
// 	}
//
//
// //WHERE WEEKOFYEAR(date)=WEEKOFYEAR(NOW())'
//
// 	//Output course events with items in cart:
//
// }










 ?>
<!-- 
</table> -->
</div>

<div class="col-md-1"></div>
