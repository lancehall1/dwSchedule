<?php
if (!session_id()) {
    session_start();
}

if ($_SESSION['role'] != 1) {
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

    td{
      position:relative;
      padding-top:20px;
    }

    .greenPlus{
      margin:3px 3px 3px 3px; 
      height:15px; right:0; top:0; 
      display:inline; 
      cursor:pointer; 
      position:absolute;
    }
    th,td{
      width:12.5%;
    }
	</style>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/loader.css">
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
              $('.Sunday').html('');
              $('.Monday').html('');
              $('.Tuesday').html('');
              $('.Wednesday').html('');
              $('.Thursday').html('');
              $('.Friday').html('');
              $('.Saturday').html('');

              selectCurrentWeek();

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
                    $('#' + employeeId).find('.' + weekday[modifiedDay]).append('<div><p style="display:inline;">' + startTime + ' - ' + stopTime + '</p> <img style="height:15px; display:inline; cursor:pointer;" onclick="deleteShift(' + response2[key]['ID'] + ', this)" src="img/redx.png" /></div>'); 
                  }

                  $('.Sunday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                  $('.Monday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                  $('.Tuesday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                  $('.Wednesday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                  $('.Thursday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                  $('.Friday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                  $('.Saturday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                  stopLoader();      
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
</head>

<body>
  <a href="schedule-employees.php">Employees</a>
  <a href="schedule-defaults.php">Modify Defaults</a>
  <button onClick="saveShifts()">Save</button>
  <div class="week-picker"></div>
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
    $( document ).ready(function() {
      var urlParams = new URLSearchParams(window.location.search);
      var day = urlParams.get('day');
      var month = urlParams.get('month');
      var year = urlParams.get('year');

      $( ".week-picker" ).datepicker( "setDate", month + "/" + day + "/" + year );
      //window.setTimeout(function () {
      //        $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
      //    }, 1);
      $('.week-picker').find('.ui-datepicker-current-day a').trigger('click');
    });

    $.getJSON('php/employeesToCalendar.php', function(response) {
      // response is a JSON object that contains all the info from de sql query
      /* do your JS stuff here */
      for (var key in response) {
        $( "#scheduleTable tr:last" ).after( "<tr id=" + response[key]['ID'] + "><td>" + response[key]['FullName'] + '<button onClick="fillDefaults(this)">Defaults</button>' + '</td><td class="Sunday"></td><td class="Monday"></td><td class="Tuesday"></td><td class="Wednesday"></td><td class="Thursday"></td><td class="Friday"></td><td class="Saturday"></td></tr>' );
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

    function deleteShift(ID, e){
      $.ajax({
          cache: false,
          type: "POST",
          url: 'php/deleteShift.php',
          data: { ID:ID }
      });
      $(e).parent().html('');
    }

    function addShiftInputs(e){
      $(e).parent().append('<div class="timeInputDiv"><input class="startTime" style="display:inline; width:80px;" type="time" value="12:00:00"/> <p style="display:inline;">&nbspto&nbsp</p> <input class="stopTime" style="display:inline;width:80px;" type="time" value="12:00:00"/><img style="height:15px; display:inline; cursor:pointer;" onclick="deleteInputs(this)" src="img/redx.png" /></div>');
    }

    function saveShifts(){
      startLoader();
      var timeInputDivs = document.getElementsByClassName("timeInputDiv");
      var startTime;
      var stopTime;
      var date;
      var employeeId;
      var startDate;
      var startDateObj;
      var dayOfWeekInt;
      for(var i = 0; i < timeInputDivs.length; i++)
      {
        for (var j = 0; j < timeInputDivs[i].childNodes.length; j++) {
          if (timeInputDivs[i].childNodes[j].className == "startTime") {
            startTime = timeInputDivs[i].childNodes[j].value + ':00';
          }
          if (timeInputDivs[i].childNodes[j].className == "stopTime") {
            stopTime = timeInputDivs[i].childNodes[j].value + ':00';
          }  
          employeeId = timeInputDivs[i].parentElement.parentElement.id;   
          dayOfWeekInt = timeInputDivs[i].parentElement.className;  
        }   
        var tmpStartDateArr;
        var tmpStopDateArr;
        var weekday=new Array(7);
        weekday[0]="Sunday";
        weekday[1]="Monday";
        weekday[2]="Tuesday";
        weekday[3]="Wednesday";
        weekday[4]="Thursday";
        weekday[5]="Friday";
        weekday[6]="Saturday";    

        startDate = $('#startDate').text();
        tmpStartDateArr = startDate.split('/');

        startDateObj = new Date(startDate);
        //startDateObj = startDateObj + weekday.indexOf(dayOfWeekInt);
        startDateObj.setDate(startDateObj.getDate() + weekday.indexOf(dayOfWeekInt));
        startDate = startDateObj.toISOString().substring(0, 10);

        var months=new Array(12);
        months[0]="January";
        months[1]="February";
        months[2]="March";
        months[3]="April";
        months[4]="May";
        months[5]="June";
        months[6]="July";   
        months[7]="August";   
        months[8]="September";   
        months[9]="October";   
        months[10]="November";   
        months[11]="December";

        var selectedCalendarElement = $('.ui-state-active:first').text();
        var selectedCalendarMonth = $('.ui-datepicker-month').text();
        var selectedCalendarYear = $('.ui-datepicker-year').text();
        selectedCalendarMonth = months.indexOf(selectedCalendarMonth) + 1;

        $( ".week-picker:contains('" + selectedCalendarElement + "')" ).css( "text-decoration", "underline" );

        request = $.ajax({
            cache: false,
            type: "POST",
            url: 'php/updateSchedule.php',
            data: {startTime:startTime, stopTime:stopTime, employeeId:employeeId, startDate:startDate}
        });                        
      }
      window.location = "./schedule-admin.php?day=" + selectedCalendarElement + "&month=" + selectedCalendarMonth + "&year=" + selectedCalendarYear;
    }

    function deleteInputs(e){
      $(e).parent().remove();    
    }

    function fillDefaults(e){
      startLoader();
      var startDateObj = new Date($('#startDate').text());
      var stopDateObj = new Date($('#endDate').text());
      var startDate = startDateObj.toISOString().substring(0, 10);
      var stopDate = stopDateObj.toISOString().substring(0, 10);
      $.ajax({
        url: "php/fillDefaults.php",
        type: "post", 
        data: { 
          employeeId: $(e).parent().parent().attr('id'),
          startDate: startDate,
          stopDate: stopDate
        },
        success: function() {
          location.reload();
        }
        error: function() {
          stopLoader();
          alert("Failed to fill defaults");
        }
      });
    }

    function startLoader() {
      $('#loaderModal').css("display", "block");
    }

    function stopLoader() {
      $('#loaderModal').css("display", "none");
    }
  </script>
  <div id="loaderModal" class="modal">
    <div id="loader"></div>
  </div> 
</body>
</html>
