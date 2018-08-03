<?php
if (!session_id()) {
    session_start();
}

if ($_SESSION['username'] == null) {
    header("Location:schedule.php");
    die();
}
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Devil Wind Brewing</title>
  <link rel="stylesheet" href="css/styles.css?v=1.0">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css">
  <script type="text/javascript">
  $(function() {
      var startDate;
      var endDate;

      var selectCurrentWeek = function() {
          window.setTimeout(function () {
              $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
          }, 1);
      }

      $('.week-picker').datepicker( {
          showOtherMonths: true,
          selectOtherMonths: true,
          onSelect: function(dateText, inst) {
              var date = $(this).datepicker('getDate');
              startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
              endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
              var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
              $('#startDate').text($.datepicker.formatDate( dateFormat, startDate, inst.settings ));
              $('#endDate').text($.datepicker.formatDate( dateFormat, endDate, inst.settings ));

              selectCurrentWeek();

              $('.Sunday').html('');
              $('.Monday').html('');
              $('.Tuesday').html('');
              $('.Wednesday').html('');
              $('.Thursday').html('');
              $('.Friday').html('');
              $('.Saturday').html('');

              var weekday=new Array(7);
                weekday[0]="Sunday";
                weekday[1]="Monday";
                weekday[2]="Tuesday";
                weekday[3]="Wednesday";
                weekday[4]="Thursday";
                weekday[5]="Friday";
                weekday[6]="Saturday";                

              $.ajax({
                url: "php/populateSchedule.php",
                type: "get", //send it through get method
                data: { 
                  endDate: formatDate(endDate),
                  startDate: formatDate(startDate)
                },
                success: function(response) {
                  console.log(response);
                  var response2 = JSON.parse(response);
                  for (var key in response2) {
                    console.log('EmployeeId=' + response2[key]['EmployeeId']);
                    var date = new Date(response2[key]['ScheduleDate']);
                    var day = date.getDay();  
                    $('#' + response2[key]['EmployeeId']).find('.' + weekday[day + 1]).append('<p>' + response2[key]['StartTime'] + ' - ' + response2[key]['StopTime'] + '</p>');          
                  }
                }
              });              
          },
          beforeShowDay: function(date) {
              var cssClass = '';
              if(date >= startDate && date <= endDate)
                  cssClass = 'ui-datepicker-current-day';
              return [true, cssClass];
          },
          onChangeMonthYear: function(year, month, inst) {
              selectCurrentWeek();
          }
      });

      $('.week-picker .ui-datepicker-calendar tr').live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
      $('.week-picker .ui-datepicker-calendar tr').live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
  });
  </script>

	<style>
	  table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;
	  }

	  td, th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
	  }

	  tr:nth-child(even) {
		background-color: #dddddd;
	  }
	</style>

</head>

<body>
  <div class="week-picker"></div>
  <button onClick="highlightReleaseableShifts()">Release Shift</button>
    <br /><br />
    <label>Week :</label> <span id="startDate"></span> - <span id="endDate"></span>
    <table id="scheduleTable">
      <tr>
        <th>Name</th>
        <th>Sunday</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
      </tr>
    </table>
  <script>
    $(document).ready(function(){
        var role='<?php echo $_SESSION['role'];?>';
        $('.week-picker').find('.ui-datepicker-current-day a').trigger('click');
    });

    $.getJSON('php/employeesToCalendar.php', function(response) {
      // response is a JSON object that contains all the info from de sql query
      /* do your JS stuff here */
      for (var key in response) {
        console.log(' name=' + response[key]['FullName']);
		    console.log(' ID=' + response[key]['ID']);
        $( "#scheduleTable tr:last" ).after( "<tr id=" + response[key]['ID'] + "><td>" + response[key]['FullName'] + '</td><td class="Sunday"></td><td class="Monday"></td><td class="Tuesday"></td><td class="Wednesday"></td><td class="Thursday"></td><td class="Friday"></td><td class="Saturday"></td></tr>' );
      }
    });

    function formatDate(d) {
    //var d = new Date(date),
        var month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
    }

    function highlightReleaseableShifts(){
      $('#<?php echo $_SESSION['employeeId'] ?> td p').css("background-color", "lightblue");
    }
  </script>


</body>
</html>
