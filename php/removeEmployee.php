<?php
if (!session_id()) session_start();
if ($_SESSION['role'] != 1){ 
    header("Location:../schedule.php");
    die();
}
$ID2 = $_POST['data'];
$ID = (int)$ID2;
include 'mysql-credentials.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql2 = "DELETE FROM Employees WHERE Employees.ID = $ID";
$conn->query($sql2);
$sql2 = "DELETE FROM Schedule WHERE Schedule.EmployeeId = $ID";
$conn->query($sql2);
$sql2 = "DELETE FROM DefaultTimes WHERE DefaultTimes.EmployeeId = $ID";
$conn->query($sql2);

$conn->close();
header("Location:../schedule-employees.php");
die();
?>