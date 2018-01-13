<div class="col-md-1"></div>
<div class="col-md-10">

  <form class="navbar-form navbar-left" style="display:table;"  method="post" action="" id="my-form" role="search">
    <div class="form-group">
      <input type="text" name="search_room" id="searchbox_room"  placeholder="Room name" autofocus/>
    </div>
  </form>
  <br>

  <?php
    if(isset($_GET['room_name'])){
      $room_name = $_GET['room_name'];
      $_SESSION['room_name'] = $room_name;
      //$room_name = str_replace('+','%20',$room_name);
      //$_SESSION['room_name'] = $room_name;
      echo '<h2 class="page-header">Selected room: ';
      echo '<a href="'.$app_path.'location/'.str_replace('+','%2B',$room_name).'">'.$room_name.'<span class="glyphicon glyphicon-map-marker"></span></a></h2>';
    }else{
      echo '<h1 class="page-header">No room selected</h1>';
    }
  ?>
<script>

$(document).ready(function() {

  var default_date = new Date();

  $('#searchbox_room').typeahead({
    name: 'room',
    prefetch: '<?php echo "$app_path"; ?>includes/show_rooms.php',
    limit: 7
    }).on('typeahead:selected', function(e){
    e.target.form.submit();
  });

  $('#calendar_room').fullCalendar({
    height: 'auto',
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
    axisFormat: 'HH:mm',
    timeFormat: {
        agenda: 'HH:mm',
        month: 'HH:mm',

    },
    displayEventEnd: {
                  month: true,
                  basicWeek: true,
                  "default": true
              },
    titleFormat: {
      month: 'MMMM YYYY',
      week: "D.M.YYYY",
      day: 'D.M'
    },
    columnFormat: {
      month: 'ddd',
      week: 'ddd D.M',
      day: 'dddd D.M'
    },
    weekNumberCalculation: 'ISO',
    allDaySlot: false,
    defaultDate: default_date,
    weekNumbers: true,
    firstDay: 1,
    minTime: "08:00",
    maxTime: "20:00",
    //eventLimit: true,
    //defaultView: 'agendaWeek',
    defaultView: Cookies.get('fullCalendarCurrentView') || 'month',
    defaultDate: Cookies.get('fullCalendarCurrentDate') || null,
    viewRender: function(view) {
      Cookies.set('fullCalendarCurrentView', view.name, {path: ''});
      Cookies.set('fullCalendarCurrentDate', view.intervalStart.format(), {path: ''});
    },
    businessHours: {
      start: '8:00', // a start time (10am in this example)
      end: '20:00',
      dow: [ 1, 2, 3, 4, 5, 6]
    },
    hiddenDays: [ 0, 6],
    //selectable: true,
    //selectHelper: true,
    //droppable: true,
    //editable: true,
    slotEventOverlap: false,
    //eventLimit: true,
    select: function(start, end, allDay) {
      var s1 = new Date(start);
      var s2 = new Date(end);
      //yyyy-mm-dd hh-mm
      $('#start_time').val(s1.getFullYear() + "-" + (s1.getMonth()+1) + "-" + s1.getDate() + " " + s1.getUTCHours() + ":" + s1.getMinutes());
      $('#end_time').val(s2.getFullYear() + "-" + (s2.getMonth()+1) + "-" + s2.getDate() + " " + s2.getUTCHours() + ":" + s2.getMinutes());
      $('#modal_form1').click();
      //GetCalendarDateRange();
    },
    eventRender: function ( event, element ) {
      //element.find('.fc-time').before($("<div class=\"fc-event-icons\"></div>").html('<div class="glyphicon glyphicon-comment pull-right" > ' + event.event_comments + '</div>'));
    },
    eventResize: function(event, delta, revertFunc) {

      var str1 = String(event.title);
      var str2 = 'PERSONAL';
      if(str1.indexOf(str2) > -1){
        if (confirm("Save change to database (resize)?")) {
          var s1 = new Date(event.start);
          var s2 = new Date(event.end);

          $.ajax({
            type: "POST",
            url: "index.php",
            data: {
              "start_time": String(s1.getFullYear() + "-" + (s1.getMonth()+1) + "-" + s1.getDate() + " " + s1.getUTCHours() + ":" + s1.getMinutes()),
              "end_time": String(s2.getFullYear() + "-" + (s2.getMonth()+1) + "-" + s2.getDate() + " " + s2.getUTCHours() + ":" + s2.getMinutes()),
              "event_description": String(event.description),
              "event_name": String(event.event_title),
              "event_location": String(event.event_location),
              "event_update": String(event.db_id)
            },
            success: function() {
              //alert("suc2");
            }
          });

        }else{
          revertFunc();
        }
      }
    },
    eventDrop: function(event, delta, revertFunc) {

      var str1 = String(event.title);
      var str2 = 'PERSONAL';
      if(str1.indexOf(str2) > -1){
        if (confirm("Save change to database (drop)?")) {
          var s1 = new Date(event.start);
          var s2 = new Date(event.end);

          $.ajax({
            type: "POST",
            url: "index.php",
            data: {
              "start_time": String(s1.getFullYear() + "-" + (s1.getMonth()+1) + "-" + s1.getDate() + " " + s1.getUTCHours() + ":" + s1.getMinutes()),
              "end_time": String(s2.getFullYear() + "-" + (s2.getMonth()+1) + "-" + s2.getDate() + " " + s2.getUTCHours() + ":" + s2.getMinutes()),
              "event_description": String(event.description),
              "event_name": String(event.event_title),
              "event_location": String(event.event_location),
              "event_update": String(event.db_id)
            },
            success: function() {
              //  alert("suc1");
            }
          });
        }else{
          revertFunc();
        }
      }
    },
    eventClick: function(calEvent, jsEvent, view) {
      var str1 = String(calEvent.title);
      var str2 = 'PERSONAL';

      //personal events:
      if(str1.indexOf(str2) > -1){
        var s1 = new Date(calEvent.start);
        var s2 = new Date(calEvent.end);
        $('#start_time2').val(s1.getFullYear() + "-" + (s1.getMonth()+1) + "-" + s1.getDate() + " " + s1.getUTCHours() + ":" + s1.getMinutes());
        $('#end_time2').val(s2.getFullYear() + "-" + (s2.getMonth()+1) + "-" + s2.getDate() + " " + s2.getUTCHours() + ":" + s2.getMinutes());
        $('#event_name').val(calEvent.event_title);
        $('#comment_field').val(calEvent.description);
        $('#event_location').val(calEvent.event_location);
        $('#event_id').val(calEvent.db_id);
        $('#myModal_edit').modal('show');
      //course events:
      }else {
        var s1 = new Date(calEvent.start);
        var s2 = new Date(calEvent.end);
        var start_date1 = "(" + s2.getDate() + "." + (s2.getMonth()+1) + "." + s2.getFullYear()+ ") ";
        var start_time1 = "" + ("0" + s1.getUTCHours()).slice(-2) + ":" + ("0" + s1.getMinutes()).slice(-2) + " - "+ ("0" + s2.getUTCHours()).slice(-2) + ":" + ("0" + s2.getMinutes()).slice(-2);
        var str22 = "";

        if (calEvent.event_type=="EXAM"){
          str22 = '<a href="https://uni.lut.fi/tentit-ja-valikokeet" target="_blank"> ' + calEvent.event_location + '</a> ';
        }else {
          var location = calEvent.event_location.replace("+", "%2B");
          str22 = '<a href="location/'+ location + '"> '+ calEvent.event_location + '</a> ';
        }
        $('#event_updated').html('Found in UNI at ' + calEvent.event_first_insert + '<br> Last updated at ' + calEvent.event_updated)+ '';
        $('#hide_event_id').val(calEvent.id);
        $('#event_name_1').html(calEvent.event_course + " (" + calEvent.event_type + ")<br> " + calEvent.event_name);
        $('#event_start_1').html('<span class="glyphicon glyphicon-time"></span> ' + start_time1 + " " + start_date1);
        // $('#event_location_1').html('<span class="glyphicon glyphicon-map-marker"></span> ' + str22);
        $('#event_comment_1').html('<span class="glyphicon glyphicon-info-sign"></span>  ' + calEvent.description);
        url_str = calEvent.event_course.substr(0, 9);
        $("#courseinfo_weboodi").load("<?php echo $app_path;?>includes/show_info_weboodi.php?course_code=" + url_str);
        var setti_time = calEvent.starting_string_time;
        var url_site = "<?php echo $app_path;?>includes/show_comments_for_event.php?course_short=" + calEvent.event_course.replace(" ", "%20") + "&start_time=" + setti_time.replace(" ", "%20");
        $('#event_comment_2').load(url_site.toString());
        var url_site2 = "<?php echo $app_path;?>includes/popularity.php?course_short=" + calEvent.event_course.replace(" ", "%20");
        $('#event_popularity').load(url_site2.toString());
        $('#myModal_remove').modal('show');
      }
    },
    eventSources: [
        {
            url: '<?php echo "$app_path"; ?>includes/show_room_events.php',
            type: 'POST',
            error: function() {
            }
        }
    ]
  });

  $("#load_weboodi").click(function(){
      $("#courseinfo_weboodi").load("<?php echo "$app_path"; ?>includes/show_info_weboodi.php?course_code=" + url_str);
  });

  $(document).on("click", "#load_weboodi", function(){
    $("#courseinfo_weboodi").load("<?php echo "$app_path"; ?>includes/show_info_weboodi.php?course_code=" + url_str);
  });

});
</script>


  <div class="span2" id='calendar_room'></div>
</div>
<div class="col-md-1"></div>










<div class="modal fade" id="myModal_remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"><div id="event_name_1">1</div></h4>
				</div>
				<div class="modal-body">
          <div id="event_start_1">event_start_1</div>
					<div id="event_comment_1">event_comment_1</div>
					<div id="event_comment_2"><div class="loader4">Loading comments... <img src="<?php echo $app_path; ?>images\page-loader.gif" ></div></div>
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

				</div>
		</div>
	</div>
</div>
