<?php
if (!session_id()) session_start();
if ($_SESSION['role'] != 1){ 
    header("Location:../schedule.php");
    die();
}
$ID2 = $_POST['data'];
$ID = (int)$ID2;
<<<<<<< HEAD
$servername = "us-cdbr-iron-east-01.cleardb.net";
$username = "lancehall1";
$password = "Lolipop0";
$dbname = "heroku_01b86a6647f084a";
=======
include 'mysql-credentials.php';
>>>>>>> 6223a4eb52221572413e3813402862c119b84adc

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