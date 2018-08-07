<?php
if (!session_id()) session_start();
if ($_SESSION['role'] != 1){ 
    header("Location:../schedule.php");
    die();
}
$startTime = $_POST['startTime'];
$stopTime = $_POST['stopTime'];
$employeeId = $_POST['employeeId'];
$startDate = $_POST['startDate'];
include 'mysql-credentials.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql2 = "SELECT * FROM Schedule WHERE Schedule.EmployeeId = '$employeeId' AND Schedule.StartTime = '$startTime' AND Schedule.StopTime = '$stopTime' AND Schedule.ScheduleDate = '$startDate'";
$result = $conn->query($sql2);

if ($result->num_rows == 0) {
    $sql = "INSERT INTO Schedule (StartTime, StopTime, EmployeeId, ScheduleDate)
    VALUES ('$startTime', '$stopTime', '$employeeId', '$startDate')";

    $conn->query($sql);
} 

$conn->close();

header("Location:../schedule-admin.php");
?>