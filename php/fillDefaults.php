<?php
  if (!session_id()) {
      session_start();
  }
  if ($_SESSION['role'] != 1) {
	  header("Location:../schedule.php");
	  die();
  }
    include 'mysql-credentials.php';
    $employeeId = $_POST['employeeId'];
    $startDate = $_POST['startDate'];
    $stopDate = $_POST['stopDate'];
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM Schedule WHERE Schedule.EmployeeId = '$employeeId' AND Schedule.ScheduleDate >= '$startDate' AND Schedule.ScheduleDate <= '$stopDate'";
    $conn->query($sql);

    $sql2 = "SELECT * FROM DefaultTimes where DefaultTimes.EmployeeId = '$employeeId' AND DefaultTimes.DayOfWeek = 'Sunday'";
    $result = $conn->query($sql2);

    while($row = $result->fetch_assoc())
    {
        $startTime = $row['StartTime'];
        $stopTime = $row['StopTime'];
        $sql3 = "INSERT INTO Schedule (StartTime, StopTime, EmployeeId, ScheduleDate)
            VALUES ('$startTime', '$stopTime', '$employeeId', '$startDate')";
        $conn->query($sql3);
    }

    $sql3 = "SELECT * FROM DefaultTimes where DefaultTimes.EmployeeId = '$employeeId' AND DefaultTimes.DayOfWeek = 'Monday'";
    $result2 = $conn->query($sql3);

    while($row = $result2->fetch_assoc())
    {
        $startTime = $row['StartTime'];
        $stopTime = $row['StopTime'];
        $startDate2 = date('Y-m-d', strtotime($startDate. ' + 1 days'));
        $sql3 = "INSERT INTO Schedule (StartTime, StopTime, EmployeeId, ScheduleDate)
            VALUES ('$startTime', '$stopTime', '$employeeId', '$startDate2')";
        $conn->query($sql3);
    }

    $sql4 = "SELECT * FROM DefaultTimes where DefaultTimes.EmployeeId = '$employeeId' AND DefaultTimes.DayOfWeek = 'Tuesday'";
    $result3 = $conn->query($sql4);

    while($row = $result3->fetch_assoc())
    {
        $startTime = $row['StartTime'];
        $stopTime = $row['StopTime'];
        $startDate2 = date('Y-m-d', strtotime($startDate. ' + 2 days'));
        $sql4 = "INSERT INTO Schedule (StartTime, StopTime, EmployeeId, ScheduleDate)
            VALUES ('$startTime', '$stopTime', '$employeeId', '$startDate2')";
        $conn->query($sql4);
    }

    $sql5 = "SELECT * FROM DefaultTimes where DefaultTimes.EmployeeId = '$employeeId' AND DefaultTimes.DayOfWeek = 'Wednesday'";
    $result4 = $conn->query($sql5);

    while($row = $result4->fetch_assoc())
    {
        $startTime = $row['StartTime'];
        $stopTime = $row['StopTime'];
        $startDate2 = date('Y-m-d', strtotime($startDate. ' + 3 days'));
        $sql5 = "INSERT INTO Schedule (StartTime, StopTime, EmployeeId, ScheduleDate)
            VALUES ('$startTime', '$stopTime', '$employeeId', '$startDate2')";
        $conn->query($sql5);
    }

    $sql6 = "SELECT * FROM DefaultTimes where DefaultTimes.EmployeeId = '$employeeId' AND DefaultTimes.DayOfWeek = 'Thursday'";
    $result5 = $conn->query($sql6);

    while($row = $result5->fetch_assoc())
    {
        $startTime = $row['StartTime'];
        $stopTime = $row['StopTime'];
        $startDate2 = date('Y-m-d', strtotime($startDate. ' + 4 days'));
        $sql6 = "INSERT INTO Schedule (StartTime, StopTime, EmployeeId, ScheduleDate)
            VALUES ('$startTime', '$stopTime', '$employeeId', '$startDate2')";
        $conn->query($sql6);
    }

    $sql7 = "SELECT * FROM DefaultTimes where DefaultTimes.EmployeeId = '$employeeId' AND DefaultTimes.DayOfWeek = 'Friday'";
    $result6 = $conn->query($sql7);

    while($row = $result6->fetch_assoc())
    {
        $startTime = $row['StartTime'];
        $stopTime = $row['StopTime'];
        $startDate2 = date('Y-m-d', strtotime($startDate. ' + 5 days'));
        $sql7 = "INSERT INTO Schedule (StartTime, StopTime, EmployeeId, ScheduleDate)
            VALUES ('$startTime', '$stopTime', '$employeeId', '$startDate2')";
        $conn->query($sql7);
    }

    $sql8 = "SELECT * FROM DefaultTimes where DefaultTimes.EmployeeId = '$employeeId' AND DefaultTimes.DayOfWeek = 'Saturday'";
    $result7 = $conn->query($sql8);

    while($row = $result7->fetch_assoc())
    {
        $startTime = $row['StartTime'];
        $stopTime = $row['StopTime'];
        $startDate2 = date('Y-m-d', strtotime($startDate. ' + 6 days'));
        $sql8 = "INSERT INTO Schedule (StartTime, StopTime, EmployeeId, ScheduleDate)
            VALUES ('$startTime', '$stopTime', '$employeeId', '$startDate2')";
        $conn->query($sql8);
    }

    $conn->close();
?>