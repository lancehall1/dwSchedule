<?php
if (!session_id()) session_start();
if ($_SESSION['role'] != 1){ 
    header("Location:../schedule.php");
    die();
}
$name = $_POST['Name'];
$phone = $_POST['Phone'];
$email = $_POST['Email'];
$servername = "sql13.bravehost.com";
$username = "lhall";
$password = "Lolipop0";
$dbname = "dwDatabase_2820268";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql2 = "SELECT * FROM Employees WHERE Employees.FullName = '$name'";
$result = $conn->query($sql2);

if ($result->num_rows == 0) {
    $sql = "INSERT INTO Employees (FullName, Phone, Email)
    VALUES ('$name', '$phone', '$email')";

    if ($conn->query($sql) === true) {
        echo "<script type='text/javascript'>alert('You have successfully added an employee.');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "<script type='text/javascript'>alert('You have already added this employee.');</script>";
}

$conn->close();
header("Location:../schedule-employees.php");
die();
?>