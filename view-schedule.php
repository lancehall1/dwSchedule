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
  var shiftsInCalendar = false;
  //first we want to retrieve and populate the table with employee names, then we can call the schedule populator to fill in the shifts
  //this way we ensure that the shifts are never populated without a list of employees
  $.getJSON('php/employeesToCalendar.php', function(response) {
      // response is a JSON object that contains all the info from de sql query
      for (var key in response) {
        $( "#scheduleTable tr:last" ).after( "<tr id=" + response[key]['ID'] + "><td>" + response[key]['FullName'] + '</td><td class="Sunday"></td><td class="Monday"></td><td class="Tuesday"></td><td class="Wednesday"></td><td class="Thursday"></td><td class="Friday"></td><td class="Saturday"></td></tr>' );
      }
      //we populate shifts only when employees are in the calendar
      populateShifts();
    });

  function populateShifts() {
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
                  var response2 = JSON.parse(response);
                  for (var key in response2) {
                    var date = new Date(response2[key]['ScheduleDate']);
                    var day = date.getDay();  

                    var stopTime= response2[key]['StopTime'];
                    var startTime = response2[key]['StartTime'];
                    var employeeId = response2[key]['EmployeeId'];

                    var tmpArrStart = startTime.split(':');
                    if(tmpArrStart[0] == 12){
                      startTime = tmpArrStart[0] + ':' + tmpArrStart[1] + ' pm';
                    }
                    else if(+tmpArrStart[0] == 00) {
                        startTime = '12:' + tmpArrStart[1] + ' am';
                      } 
                      else if(+tmpArrStart[0] > 12) {
                        startTime = (+tmpArrStart[0]-12) + ':' + tmpArrStart[1] + ' pm';
                      } 
                      else {
                        startTime = (+tmpArrStart[0]) + ':' + tmpArrStart[1] + ' am';
                      }

                    var tmpArrStop = stopTime.split(':');
                    if(tmpArrStop[0] == 12){
                      stopTime = tmpArrStop[0] + ':' + tmpArrStop[1] + ' pm';
                    }
                    else if(+tmpArrStop[0] == 00) {
                      stopTime = '12:' + tmpArrStop[1] + ' am';
                    } 
                    else if(+tmpArrStop[0] > 12) {
                      stopTime = (+tmpArrStop[0]-12) + ':' + tmpArrStop[1] + ' pm';
                    } 
                    else {
                      stopTime = (+tmpArrStop[0]) + ':' + tmpArrStop[1] + ' am';
                    }

                    var modifiedDay;
                    if(day < 6)
                    {
                      modifiedDay = day + 1;
                    }
                    else if(day == 6)
                    {
                      modifiedDay = 0;
                    }

                    //we append the ID of the schedule record so that it's easier to reference when it comes time to release shifts
                    $('#' + response2[key]['EmployeeId']).find('.' + weekday[modifiedDay]).append('<div id="' + response2[key]['ID'] + '"><p>' + startTime + ' - ' + stopTime + '</p></div>');          
                    if(response2[key]['Released'] == 1)
                    {
                      $('#' + response2[key]['ID'] + ' p').css('border', '5px solid blue');
                      $('#' + response2[key]['ID'] + ' p').css('background-color', 'transparent');
                    }
                  }
                  shiftsInCalendar = true;
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
      $('.week-picker').find('.ui-datepicker-current-day a').trigger('click');
  }
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
      //make sure shifts are actually in the display table before highlighting them
      //probably unnecessary unless the DB is slow and user is impatient
      var timeout = 5;
      while (!shiftsInCalendar) {
        //note: check following method if errors on website
        setTimeout(function() {
        }, (100));
        timeout--;
        if (timeout < 1) {console.log("Database timeout.");break;}
      }
      if (shiftsInCalendar) {
        if(<?php echo $_SESSION['role']?> != 1){
          $('#<?php echo $_SESSION['employeeId']?> td p').css("background-color", "pink");
          $('#scheduleTable td p').css("position", "relative");
          $('#<?php echo $_SESSION['employeeId']?> td p').append('<div style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:transparent" onClick="releaseShift(this)"></div>');
        }
        else{
          $('#scheduleTable td p').css("background-color", "pink");
          $('#scheduleTable td p').css("position", "relative");
          $('#scheduleTable td p').append('<div style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:transparent" onClick="releaseShift(this)"></div>');

        }
      }
      else {console.log("Failed to get employees from server database.")}
    }

    function releaseShift(e) {
      var tmpStr = $(e).parent().parent().attr('id');
      $.ajax({
          cache: false,
          type: "POST",
          url: 'php/releaseShift.php',
          data: { ID: tmpStr},
          success: function(){
            $('#' + tmpStr + ' p').css('border', '5px solid blue');
            $('#' + tmpStr + ' p').css("background-color", "transparent");
          }
      });
      $.ajax({
        url: "mail/release_shift_email.php",
        type: "POST",
        data: {
          name: name,
          date: date,
          startTime: startTime,
          endTime: endTime
        });
    }
  </script>


</body>
</html>
