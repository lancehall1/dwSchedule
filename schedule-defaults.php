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
</head>

<body>
  <a href="user-panel.php">Home</a>
  <a href="schedule-admin.php">Back to schedule administration</a>
  <a href="logout.php">Log out</a>
  <p>
  <a href="schedule-employees.php">Employees</a>
  <button onClick="saveDefaults()">Save</button>
    <br /><br />
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
    $.getJSON('php/employeesToCalendar.php', function(response) {
      // response is a JSON object that contains all the info from de sql query
      /* do your JS stuff here */
      for (var key in response) {
        $( "#scheduleTable tr:last" ).after( "<tr id=" + response[key]['ID'] + "><td>" + response[key]['FullName'] + '</td><td class="Sunday"></td><td class="Monday"></td><td class="Tuesday"></td><td class="Wednesday"></td><td class="Thursday"></td><td class="Friday"></td><td class="Saturday"></td></tr>' );
      }
      $('.Sunday').html('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
      $('.Monday').html('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
      $('.Tuesday').html('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
      $('.Wednesday').html('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
      $('.Thursday').html('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
      $('.Friday').html('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
      $('.Saturday').html('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
    });

    function deleteDefault(ID, e){
      $.ajax({
          cache: false,
          type: "POST",
          url: 'php/deleteDefault.php',
          data: { ID:ID }
      });
      $(e).parent().html('');
    }

    function addShiftInputs(e){
       $(e).parent().append('<div class="timeInputDiv"><input class="startTime" style="display:inline; width:80px;" type="time" value="12:00:00"/> <p style="display:inline;">&nbspto&nbsp</p> <input class="stopTime" style="display:inline;width:80px;" type="time" value="12:00:00"/><img style="height:15px; display:inline; cursor:pointer;" onclick="deleteInputs(this)" src="img/redx.png" /></div>');
    }
	
	function deleteInputs(e){
      $(e).parent().remove();    
    }

    function saveDefaults(){
      var timeInputDivs = document.getElementsByClassName("timeInputDiv");
      var startTime;
      var stopTime;
      var date;
      var employeeId;
      var startDate;
      var startDateObj;
      var dayOfWeek;
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
          dayOfWeek = timeInputDivs[i].parentElement.className;  
        }   

        request = $.ajax({
            cache: false,
            type: "POST",
            url: 'php/updateDefaults.php',
            data: {startTime:startTime, stopTime:stopTime, employeeId:employeeId, dayOfWeek:dayOfWeek},
            success: function() {
                location.reload();
            }
        });            
      }
    }

    $(document).ready(function(){
        $.ajax({
            url: "php/populateDefaults.php",
            type: "get", //send it through get method
            success: function(response) {
                var response2 = JSON.parse(response);
                for (var key in response2) {
                var stopTime= response2[key]['StopTime'];
                var startTime = response2[key]['StartTime'];
                var employeeId = response2[key]['EmployeeId'];
                var dayOfWeek = response2[key]['DayOfWeek'];

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

                $('#' + employeeId).find('.' + dayOfWeek).append('<div><p style="display:inline;">' + startTime + ' - ' + stopTime + '</p> <img style="height:15px; display:inline; cursor:pointer;" onclick="deleteDefault(' + response2[key]['ID'] + ', this)" src="img/redx.png" /></div>'); 
                }

                $('.Sunday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                $('.Monday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                $('.Tuesday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                $('.Wednesday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                $('.Thursday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                $('.Friday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');
                $('.Saturday').prepend('<img class="greenPlus" onclick="addShiftInputs(this)" src="img/greenPlus.png" />');         
            }
        });              
    });
  </script>

</body>
</html>
