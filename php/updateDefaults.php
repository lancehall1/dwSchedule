<?php
if (!session_id()) session_start();
if ($_SESSION['role'] != 1){ 
    header("Location:../schedule.php");
    die();
}
$startTime = $_POST['startTime'];
$stopTime = $_POST['stopTime'];
$employeeId = $_POST['employeeId'];
$dayOfWeek = $_POST['dayOfWeek'];
$servername = "us-cdbr-iron-east-01.cleardb.net";
$username = "lancehall1";
$password = "Lolipop0";
$dbname = "heroku_01b86a6647f084a";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql2 = "SELECT * FROM DefaultTimes WHERE DefaultTimes.EmployeeId = '$employeeId' AND DefaultTimes.StartTime = '$startTime' AND DefaultTimes.StopTime = '$stopTime' AND DefaultTimes.DayOfWeek = '$dayOfWeek'";
$result = $conn->query($sql2);

if ($result->num_rows == 0) {
    $sql = "INSERT INTO DefaultTimes (StartTime, StopTime, EmployeeId, DayOfWeek)
    VALUES ('$startTime', '$stopTime', '$employeeId', '$dayOfWeek')";

    $conn->query($sql);
} 

$conn->close();
?>